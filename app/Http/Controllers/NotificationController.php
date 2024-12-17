<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Display notifications
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        $unreadNotificationsCount = $notifications->where('status', 'unread')->count();

        return view('notifications.index', compact('notifications', 'unreadNotificationsCount'));
    }

    public function markAllAsRead(Request $request)
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->get();

        foreach ($notifications as $notification) {
            $notification->status = 'read';
            $notification->save();
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Notifications marked as read']);
        }

        return redirect()->back();
    }

    public function markAsRead(Notification $notification)
    {
        // Pastikan notifikasi milik user yang sedang login
        if ($notification->user_id == Auth::id() && $notification->status == 'unread') {
            $notification->status = 'read';
            $notification->save();

            if (request()->ajax()) {
                return response()->json(['message' => 'Notification marked as read']);
            }
        }

        return response()->json(['message' => 'Notification already read or invalid'], 400);
    }
}
