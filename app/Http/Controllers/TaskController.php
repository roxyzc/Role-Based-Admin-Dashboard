<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Task;
use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function create(Team $team)
    {
        $user = Auth::user();
        $role = $user->role->role_name;

        if ($role === 'manager') {
            if ($team->user_id !== $user->id) {
                abort(403, 'Akses ditolak');
            }
        }

        $team->load('members');

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('teams.tasks.assign_task', compact('team', 'unreadNotificationsCount'));
    }

    public function removeTask(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus tugas!');
    }

    public function store(Request $request, Team $team)
    {
        $request->validate([
            'task_name' => 'required|string|max:60|regex:/^[a-zA-Z0-9\s]+$/',
            'description' => 'required|min:50|string|regex:/^[a-zA-Z0-9\s]+$/',
            'id_user' => 'required|exists:users,id',
            'priority' => 'required|in:Low,Medium,High',
            'deadline' => 'required|date|after_or_equal:' . now(),
        ], [
            'task_name.required' => 'Nama tugas wajib diisi',
            'task_name.string' => 'Nama tugas harus berupa teks',
            'task_name.max' => 'Nama tugas tidak boleh lebih dari 255 karakter',
            'task_name.regex' => 'Nama tugas hanya boleh mengandung huruf, angka, dan spasi',
            'description.required' => 'Deskripsi wajib diisi',
            'description.string' => 'Deskripsi harus berupa teks',
            'description.min' => 'Deskripsi minimal :min',
            'description.regex' => 'Deskripsi hanya boleh mengandung huruf, angka, dan spasi',
            'id_user.required' => 'ID pengguna wajib diisi',
            'id_user.exists' => 'ID pengguna tidak valid',
            'priority.required' => 'Prioritas wajib diisi',
            'priority.in' => 'Prioritas harus salah satu dari Low, Medium, atau High',
            'deadline.required' => 'Batas waktu wajib diisi',
            'deadline.date' => 'Batas waktu harus berupa tanggal yang valid',
            'deadline.after_or_equal' => 'Batas waktu harus lebih besar atau sama dengan tanggal sekarang'
        ]);

        $task_name =  preg_replace('/\s+/', ' ', trim($request->task_name));
        $description =  preg_replace('/\s+/', ' ', trim($request->description));

        $task = Task::create([
            'task_name' => $task_name,
            'description' => $description,
            'team_id' => $team->id,
            'id_user' => $request->id_user,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
        ]);

        Notification::create([
            'user_id' => $request->id_user,
            'title' => "Anda diberikan tugas",
            'message' => "Tugas yang diberikan adalah <a href='" . route('tasks.show', ['id' => $task->id]) . "'>{$task->task_name}</a>",
            'type' => 'message',
            'status' => 'unread',
        ]);

        return redirect()->route('teams.show', $team->id)->with('success', 'Tugas berhasil diberikan.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $role = Auth::user()->role->role_name;
        if ($role == 'admin') {
            $task = Task::findOrFail($id);
        } elseif ($user->role->hasPermission('package_leader')) {
            $task = Task::where('id', $id)
                ->whereHas('team', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->firstOrFail();
        } else {
            $task = Task::where('id', $id)
                ->where('id_user', $user->id)
                ->firstOrFail();
        }

        $id_user = $task->id_user;
        $name_team = $task->team->name;
        $name_user = $task->assignee->username;
        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('teams.tasks.task-detail', compact('task', 'name_team', 'name_user', 'id_user', 'unreadNotificationsCount'));
    }

    public function uploadFile(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        $request->validate([
            'file' => 'required|file|mimes:pdf,txt,png,jpg,jpeg|max:10240',
        ], [
            'file.required' => 'File wajib diunggah.',
            'file.file' => 'File yang diunggah tidak valid.',
            'file.mimes' => 'Jenis file harus berupa PDF, TXT, PNG atau JPG',
            'file.max' => 'Ukuran file maksimal adalah 10 MB.',
        ]);

        if ($task->file) {
            Storage::disk('public')->delete($task->file);
        }

        $fileName = 'task_' . $taskId . '_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
        $filePath = $request->file('file')->storeAs('task_files', $fileName, 'public');

        $task->file = $filePath;
        $task->save();

        return redirect()->back()->with('success', 'File berhasil diunggah!');
    }

    public function updateStatus(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        $request->validate([
            'status' => 'required|in:progress,complete,pending',
        ]);

        $task->status = $request->status;
        $task->save();

        if ($request->status === 'complete') {
            $task->completion_time = now();
            ActivityLog::create([
                'user_id' => $task->id_user,
                'activity_type' => 'Tugas Selesai',
                'description' => "Tugas <a href='" . route('tasks.show', ['id' => $task->id]) . "'>{$task->task_name}</a> telah diselesaikan oleh <strong>" . Auth::user()->username . "</strong>",
            ]);

            Notification::create([
                'user_id' => $task->team->user_id,
                'title' => "Tugas Selesai",
                'message' => "Tugas <a href='" . route('tasks.show', ['id' => $task->id]) . "'>{$task->task_name}</a> telah diselesaikan oleh <strong>" . Auth::user()->username . "</strong>",
                'type' => 'message',
                'status' => 'unread',
            ]);
        } else {
            Notification::create([
                'user_id' => $task->team->user_id,
                'title' => "Status Tugas Diperbarui",
                'message' => "Status tugas <a href='" . route('tasks.show', ['id' => $task->id]) . "'>{$task->task_name}</a> telah diubah oleh <strong>" . Auth::user()->username . "</strong> menjadi <strong>{$request->status}</strong>",
                'type' => 'message',
                'status' => 'unread',
            ]);

            Notification::create([
                'user_id' => $task->id_user,
                'title' => "Status Tugas Diperbarui",
                'message' => "Status tugas <a href='" . route('tasks.show', ['id' => $task->id]) . "'>{$task->task_name}</a> telah diubah oleh <strong>" . Auth::user()->username . "</strong> menjadi <strong>{$request->status}</strong>",
                'type' => 'message',
                'status' => 'unread',
            ]);

            if ($request->status === 'pending') {
                $task->completion_time = now();
            } else {
                $task->completion_time = null;
            }
        }

        $task->save();

        if ($request->ajax()) {
            return response()->json([
                'status' => $task->status,
                'completion_time' => $task->completion_time,
            ]);
        }

        return redirect()->back();
    }

    public function workload(Request $request, $userId = null)
    {
        $user = Auth::user();
        $role = $user->role->role_name;
        $search = $request->input('search');
        $page = (int) $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $maxPage = 100;
        $maxLimit = 50;

        $limit = min(max($limit, 1), $maxLimit);
        $page = min(max($page, 1), $maxPage);

        if (($role == 'admin' || $user->role->hasPermission('package_leader')) && $userId !== null) {
            $tasks = Task::where('id_user', $userId)->get();
        } elseif (($role == 'admin' || $user->role->hasPermission('package_leader')) && $userId && $userId !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        } else {
            $userId = Auth::id();
            $tasks = Task::where('id_user', $userId)->get();
        }

        $taskCounts = [
            'Low' => $tasks->where('priority', 'Low')->count(),
            'Medium' => $tasks->where('priority', 'Medium')->count(),
            'High' => $tasks->where('priority', 'High')->count(),
        ];

        $totalWorkload = 0;
        foreach ($tasks as $task) {
            if ($task->priority === 'High') {
                $totalWorkload += 3;
            } elseif ($task->priority === 'Medium') {
                $totalWorkload += 2;
            } elseif ($task->priority === 'Low') {
                $totalWorkload += 1;
            }
        }

        $completedTasks = $tasks->where('status', 'complete');
        $now = Carbon::now();

        // Periksa idle time
        $totalIdleTimeInMinutes = Task::where('id_user', $userId)->sum('idle_time');

        // Cek tugas dalam progress dan yang overdue
        $tasksInProgress = $tasks->where('status', 'progress');
        $noTasksInProgress = $tasksInProgress->isEmpty();
        $hasOverdueTasks = $tasksInProgress->filter(fn($task) => $now->greaterThan(Carbon::parse($task->deadline)))->isNotEmpty();

        if ($noTasksInProgress || $hasOverdueTasks) {
            $totalIdleTimeInMinutesCalculated = false; // Flag untuk memastikan hanya sekali idle time ditambahkan

            foreach ($tasks as $task) {
                $deadline = Carbon::parse($task->deadline);
                $existingIdleTime = $task->idle_time ?? 0;

                // Waktu terakhir diperiksa (dari completion_time atau deadline)
                $lastCheckTime = $task->completion_time
                    ? Carbon::parse($task->completion_time)
                    : $deadline;

                // Cek apakah idle time sudah dihitung sebelumnya
                if (!$task->last_idle_calculated || Carbon::parse($task->last_idle_calculated)->diffInMinutes($now) > 0) {
                    // Hitung idle time untuk tugas yang statusnya 'progress' dan overdue
                    if ($task->status === 'progress' && $now->greaterThan($deadline)) {
                        $idleTimeInMinutes = $now->diffInMinutes($deadline);
                        $task->idle_time = $existingIdleTime + $idleTimeInMinutes;
                        $task->completion_time = $now; // Perbarui waktu terakhir diperiksa
                        $task->last_idle_calculated = $now; // Simpan waktu terakhir dihitung
                        $task->save();

                        $totalIdleTimeInMinutes += $idleTimeInMinutes;
                    } elseif ($noTasksInProgress && ($task->status === 'pending' || $task->status === 'complete')) {
                        // Jika belum ada penambahan waktu idle untuk tugas dengan status 'pending' atau 'complete'
                        if (!$totalIdleTimeInMinutesCalculated) {
                            // Hitung idle time hanya sekali
                            $idleTimeInMinutes = $now->diffInMinutes($lastCheckTime);

                            // Tambahkan waktu idle hanya jika ada selisih
                            if ($idleTimeInMinutes > 0) {
                                $task->idle_time = $existingIdleTime + $idleTimeInMinutes;
                                $task->completion_time = $now; // Perbarui waktu terakhir diperiksa
                                $task->save();

                                $totalIdleTimeInMinutes += $idleTimeInMinutes;
                            }

                            // Tandai bahwa waktu idle sudah dihitung untuk tugas dengan status 'pending' atau 'complete'
                            $totalIdleTimeInMinutesCalculated = true;
                        }
                    }
                }
            }
        }

        // Format idle time
        $totalHours = floor($totalIdleTimeInMinutes / 60);
        $totalMinutes = $totalIdleTimeInMinutes % 60;
        $formattedIdleTime = $totalHours > 0
            ? "{$totalHours} jam {$totalMinutes} menit"
            : "{$totalMinutes} menit";

        // Query dan pagination tugas
        $tasksQuery = Task::with('team')
            ->where('id_user', $userId)
            ->where(function ($query) use ($search) {
                $query->where('task_name', 'like', "%$search%");
            });

        $tasksQuery->where(function ($query) use ($search) {
            $query->where('task_name', 'like', "%$search%");
        });

        $totalTasks = $tasksQuery->count();
        $tasksPaginated = $tasksQuery->paginate($limit, ['*'], 'page', $page);

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view(
            'teams.tasks.workload',
            [
                'tasks' => $tasksPaginated,
                'totalTasks' => $totalTasks,
                'limit' => $limit,
                'taskCounts' => $taskCounts,
                'totalWorkload' => $totalWorkload,
                'completedTasks' => $completedTasks,
                'idleTime' => $formattedIdleTime,
                'currentPage' => $tasksPaginated->currentPage(),
                'totalPages' => $tasksPaginated->lastPage(),
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]
        );
    }
}
