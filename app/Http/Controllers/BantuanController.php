<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class BantuanController extends Controller
{
    function index()
    {

        $user = Auth::user();
        if ($user) {
            $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

            return view('bantuan', compact('user', 'unreadNotificationsCount'));
        }

        return view('bantuan', compact('user'));
    }
}
