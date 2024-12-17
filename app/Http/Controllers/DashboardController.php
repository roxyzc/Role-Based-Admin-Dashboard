<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Team;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('landing.page');
        }

        $user = Auth::user();

        $teamQuery = Team::query();

        if ($user->role->hasPermission('package_leader')) {
            $teamQuery->where('user_id', $user->id);
        }

        if (!$user->role->hasPermission('package_leader') && $user->role->role_name != 'admin') {
            $teamQuery->whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $teams = $teamQuery->get();

        $teamId = $request->input('team_id');

        if ($user->role->role_name == 'anggota') {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                if ($teamId && $teamId != 'all') {
                    return $team->tasks->where('team_id', $teamId)->where('id_user', Auth::id());
                }

                return $team->tasks->where('id_user', Auth::id());
            });
        } else {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                if ($teamId && $teamId != 'all') {
                    return $team->tasks->where('team_id', $teamId);
                }

                return $team->tasks;
            });
        }

        $totalProjectsCompleted = $tasks->where('status', 'complete')->count();

        $completionTimes = $tasks->where('status', 'complete')->map(function ($task) {
            if ($task->completion_time && $task->created_at) {
                return Carbon::parse($task->completion_time)->diffInMinutes(Carbon::parse($task->created_at));
            }
            return null;
        })->filter();

        $averageCompletionTimeInMinutes = $completionTimes->count() > 0 ? $completionTimes->average() : 0;

        if ($averageCompletionTimeInMinutes == 0) {
            $averageCompletionTimeFormatted = '0 menit';
        } elseif ($averageCompletionTimeInMinutes < 60) {
            $averageCompletionTimeFormatted = $averageCompletionTimeInMinutes . ' menit';
        } else {
            $hours = floor($averageCompletionTimeInMinutes / 60);
            $minutes = $averageCompletionTimeInMinutes % 60;
            $averageCompletionTimeFormatted = $hours . ' jam ' . $minutes . ' menit';
        }

        $totalProjects = $tasks->count();

        $completionPercentage = $totalProjects > 0
            ? round(($totalProjectsCompleted / $totalProjects) * 100, 2)
            : 0;


        $selectedTeamId = $request->input('team_id', null);

        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->subMonths(11)->startOfMonth()));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()));

        if ($startDate > $endDate) {
            return redirect()->route('dashboard');
        }

        $tasks = $tasks->filter(function ($task) use ($startDate, $endDate) {
            return Carbon::parse($task->created_at)->between($startDate, $endDate);
        });

        $monthlyData = $tasks->groupBy(function ($task) {
            return Carbon::parse($task->created_at)->format('Y-m');
        });

        $allMonths = collect();
        $currentMonth = $startDate->copy();
        while ($currentMonth->lte($endDate)) {
            $month = $currentMonth->format('Y-m');
            $allMonths->put($month, 0);
            $currentMonth->addMonth();
        }

        $monthlyData->each(function ($tasks, $month) use ($allMonths) {
            $allMonths[$month] = $tasks->count();
        });

        $allMonths = $allMonths->sortKeys();

        $chartLabels = $allMonths->keys()->map(function ($month) {
            return Carbon::parse($month . '-01')->format('M Y');
        })->toArray();

        $chartData = $allMonths->values()->toArray();

        $logs = ActivityLog::where('user_id', auth()->id())
            ->latest()
            ->take(3)
            ->get();

        if ($logs->isEmpty()) {
            $logs = "No recent activities found.";
        }

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('dashboard', compact(
            'logs',
            'user',
            'totalProjectsCompleted',
            'averageCompletionTimeFormatted',
            'completionPercentage',
            'chartLabels',
            'chartData',
            'teams',
            'unreadNotificationsCount',
            'selectedTeamId',
            'startDate',
            'endDate'
        ));
    }
}
