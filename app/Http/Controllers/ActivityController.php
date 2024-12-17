<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::where('user_id', auth()->id());

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');

        $maxPage = 100;
        $maxLimit = 50;

        $page = min(max($page, 1), $maxPage);
        $limit = min(max($limit, 1), $maxLimit);

        $logsQuery = $logs->latest()->when($search, function ($query) use ($search) {
            return $query->where('activity_type', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('created_at', 'like', "%$search%");
        });

        $logs = $logsQuery->paginate($limit, ['*'], 'page', $page);

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('activity-history', [
            'logs' => $logs,
            'limit' => $limit,
            'currentPage' => $logs->currentPage(),
            'totalPages' => $logs->lastPage(),
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }
}
