<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KinerjaController extends Controller
{
    function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role->role_name == 'admin') {
            $teamId = $request->input('team_id');

            $tasksQuery = Team::query();

            if ($teamId && $teamId != 'all') {
                $tasksQuery->where('id', $teamId);
            }

            $teams = $tasksQuery->get();

            $tasks = $teams->flatMap(function ($team) {
                return $team->tasks;
            });

            $completedTasks = $tasks->where('status', 'complete')->count();
            $ongoingTasks = $tasks->whereIn('status', ['progress', 'pending'])
                ->count();

            $completionTimes = $tasks->where('status', 'complete')->map(function ($task) {
                if ($task->completion_time && $task->created_at) {
                    return Carbon::parse($task->completion_time)->diffInMinutes(Carbon::parse($task->created_at));
                }
                return null;
            })->filter();

            $averageCompletionTime = $completionTimes->count() > 0 ? $completionTimes->average() : 0;

            $averageIdleTime = $tasks->average('idle_time');

            $totalTasks = $tasks->count();

            $onTimeCompletedTasks = $tasks->where('status', 'complete')->where('idle_time', 0)->count();

            $completionRate = $totalTasks > 0 ? round(($onTimeCompletedTasks / $totalTasks) * 100, 2) : 0;
            $presentase = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            $averageCompletionTimeInMinutes = $averageCompletionTime ? round($averageCompletionTime, 2) : 0;
            $averageIdleTimeInMinutes = $averageIdleTime ? round($averageIdleTime, 2) : 0;

            if ($averageCompletionTimeInMinutes < 60) {
                $averageCompletionTimeInMinutes = $averageCompletionTimeInMinutes . ' menit';
            } else {
                $hours = floor($averageCompletionTimeInMinutes / 60);
                $minutes = $averageCompletionTimeInMinutes % 60;
                $averageCompletionTimeInMinutes = $hours . ' jam ' . $minutes . ' menit';
            }

            if ($averageIdleTimeInMinutes < 60) {
                $averageIdleTimeInMinutes = $averageIdleTimeInMinutes . ' menit';
            } else {
                $hours = floor($averageIdleTimeInMinutes / 60);
                $minutes = $averageIdleTimeInMinutes % 60;
                $averageIdleTimeInMinutes = $hours . ' jam ' . $minutes . ' menit';
            }

            $productivity = $completedTasks + $ongoingTasks;
            $efficiency = $completionRate;
            $accuracy = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            $teams =  Team::all();

            $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

            return view('kinerja.index', [
                'completedTasks' => $completedTasks,
                'ongoingTasks' => $ongoingTasks,
                'averageCompletionTime' => $averageCompletionTimeInMinutes,
                'averageIdleTime' => $averageIdleTimeInMinutes,
                'completionRateTeam' => $completionRate,
                'completionRate' => 0,
                'presentase' => $presentase,
                'teams' => $teams,
                'productivity' => $productivity,
                'efficiency' => $efficiency,
                'accuracy' => $accuracy,
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        } elseif ($user->role->hasPermission('package_leader')) {
            $teamId = $request->input('team_id');

            $tasksQuery = Team::where('user_id', $user->id);

            if ($teamId && $teamId != 'all') {
                $tasksQuery->where('id', $teamId);
            }

            $teams = $tasksQuery->get();

            $tasks = $teams->flatMap(function ($team) {
                return $team->tasks;
            });

            $completedTasks = $tasks->where('status', 'complete')->count();
            $ongoingTasks = $tasks->whereIn('status', ['progress', 'pending'])
                ->count();

            $completionTimes = $tasks->where('status', 'complete')->map(function ($task) {
                if ($task->completion_time && $task->created_at) {
                    return Carbon::parse($task->completion_time)->diffInMinutes(Carbon::parse($task->created_at));
                }
                return null;
            })->filter();

            $averageCompletionTime = $completionTimes->count() > 0 ? $completionTimes->average() : 0;

            $averageIdleTime = $tasks->average('idle_time');

            $totalTasks = $tasks->count();

            $onTimeCompletedTasks = $tasks->where('status', 'complete')->where('idle_time', 0)->count();

            $completionRate = $totalTasks > 0 ? round(($onTimeCompletedTasks / $totalTasks) * 100, 2) : 0;

            $presentase = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            $averageCompletionTimeInMinutes = $averageCompletionTime ? round($averageCompletionTime, 2) : 0;
            $averageIdleTimeInMinutes = $averageIdleTime ? round($averageIdleTime, 2) : 0;

            if ($averageCompletionTimeInMinutes < 60) {
                $averageCompletionTimeInMinutes = $averageCompletionTimeInMinutes . ' menit';
            } else {
                $hours = floor($averageCompletionTimeInMinutes / 60);
                $minutes = $averageCompletionTimeInMinutes % 60;
                $averageCompletionTimeInMinutes = $hours . ' jam ' . $minutes . ' menit';
            }

            if ($averageIdleTimeInMinutes < 60) {
                $averageIdleTimeInMinutes = $averageIdleTimeInMinutes . ' menit';
            } else {
                $hours = floor($averageIdleTimeInMinutes / 60);
                $minutes = $averageIdleTimeInMinutes % 60;
                $averageIdleTimeInMinutes = $hours . ' jam ' . $minutes . ' menit';
            }

            $productivity = $completedTasks + $ongoingTasks;
            $efficiency = $completionRate;
            $accuracy = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            $teams =  Team::where('user_id', $user->id)->get();

            $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

            return view('kinerja.index', [
                'completedTasks' => $completedTasks,
                'ongoingTasks' => $ongoingTasks,
                'averageCompletionTime' => $averageCompletionTimeInMinutes,
                'averageIdleTime' => $averageIdleTimeInMinutes,
                'completionRateTeam' => $completionRate,
                'completionRate' => 0,
                'presentase' => $presentase,
                'teams' => $teams,
                'productivity' => $productivity,
                'efficiency' => $efficiency,
                'accuracy' => $accuracy,
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        } else {
            $teamId = $request->input('team_id');
            $tasksQuery = Task::where('id_user', $user->id);

            if ($teamId && $teamId != 'all') {
                $tasksQuery->where('team_id', $teamId);
            }

            $tasks = $tasksQuery->get();

            $completedTasks = $tasks->where('status', 'complete')->count();

            $ongoingTasks = $tasks->whereIn('status', ['progress', 'pending'])
                ->count();

            $completionTimes = $tasks->where('status', 'complete')->map(function ($task) {
                if ($task->completion_time && $task->created_at) {
                    return Carbon::parse($task->completion_time)->diffInMinutes(Carbon::parse($task->created_at));
                }
                return null;
            })->filter();

            $averageCompletionTime = $completionTimes->count() > 0 ? $completionTimes->average() : 0;

            $averageIdleTime = $tasks->average('idle_time');

            $totalTasks = $tasks->count();

            $onTimeCompletedTasks = $tasks->where('status', 'complete')->where('idle_time', 0)->count();

            $completionRate = $totalTasks > 0 ? round(($onTimeCompletedTasks / $totalTasks) * 100, 2) : 0;

            $presentase = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            $averageCompletionTimeInMinutes = $averageCompletionTime ? round($averageCompletionTime, 2) : 0;
            $averageIdleTimeInMinutes = $averageIdleTime ? round($averageIdleTime, 2) : 0;

            if ($averageCompletionTimeInMinutes < 60) {
                $averageCompletionTimeInMinutes = $averageCompletionTimeInMinutes . ' menit';
            } else {
                $hours = floor($averageCompletionTimeInMinutes / 60);
                $minutes = $averageCompletionTimeInMinutes % 60;
                $averageCompletionTimeInMinutes = $hours . ' jam ' . $minutes . ' menit';
            }

            if ($averageIdleTimeInMinutes < 60) {
                $averageIdleTimeInMinutes = $averageIdleTimeInMinutes . ' menit';
            } else {
                $hours = floor($averageIdleTimeInMinutes / 60);
                $minutes = $averageIdleTimeInMinutes % 60;
                $averageIdleTimeInMinutes = $hours . ' jam ' . $minutes . ' menit';
            }

            $teams = $user->teams;

            if ($teamId == 'all' || $teamId == NULL) {
                $tasks_team = Task::whereIn('team_id', $teams->pluck('id'));
            } else {
                $tasks_team = Task::where('team_id', $teamId);
            }

            $totalTasksTeam = $tasks_team->count();
            $onTimeCompletedTasksTeam = $tasks_team->where('status', 'complete')->where('idle_time', 0)->count();
            $completionRateTeam = $totalTasksTeam > 0 ? round(($onTimeCompletedTasksTeam / $totalTasksTeam) * 100, 2) : 0;

            $productivity = $completedTasks + $ongoingTasks;
            $efficiency = $completionRate;
            $accuracy = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

            $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

            return view('kinerja.index', [
                'completedTasks' => $completedTasks,
                'ongoingTasks' => $ongoingTasks,
                'averageCompletionTime' => $averageCompletionTimeInMinutes,
                'averageIdleTime' => $averageIdleTimeInMinutes,
                'completionRate' => $completionRate,
                'teams' => $teams,
                'completionRateTeam' => $completionRateTeam,
                'presentase' => $presentase,
                'productivity' => $productivity,
                'efficiency' => $efficiency,
                'accuracy' => $accuracy,
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        }
    }
}
