<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $teamQuery = Team::query();

        // switch ($user->role->role_name) {
        //     case 'manager':
        //         $teamQuery->where('user_id', $user->id);
        //         break;
        //     case 'anggota':
        //         $teamQuery->whereHas('members', function ($query) use ($user) {
        //             $query->where('user_id', $user->id);
        //         });
        //         break;
        // }

        if ($user->role->hasPermission('package_leader') && !$user->role->hasPermission('package_full_reports')) {
            $teamQuery->where('user_id', $user->id);
        }

        if (!$user->role->hasPermission('package_leader') && $user->role->role_name != 'admin') {
            $teamQuery->whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $teams = $teamQuery->get();

        // Menentukan team yang dipilih, jika tidak ada, set null
        $teamId = $request->input('team_id') ? $request->input('team_id') : ($teams->count() > 0 ? $teams[0]->id : null);

        if (!$user->role->hasPermission('package_leader')) {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                return $team->tasks->where('team_id', $teamId)->where('id_user', Auth::id());
            });
        } else {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                return $team->tasks->where('team_id', $teamId);
            });
        }

        // Mendapatkan filter yang dipilih
        $selectedTeam = $request->input('team_id') ? $request->input('team_id') : ($teams->count() ? $teams[0]->id : null);
        $selectedMonth = $request->get('month', null);

        // Cek jika selectedTeam null, jika iya set tasks sebagai array kosong
        if ($selectedTeam === null) {
            $tasks = collect(); // Mengatur data task menjadi kosong
        } else {
            // Mengambil task berdasarkan filter
            $tasksQuery = Task::with('assignee') // Menggunakan eager loading untuk assignee
                ->selectRaw('id_user, team_id, 
                            COUNT(CASE WHEN status = \'progress\' THEN 1 END) as total_tasks, 
                            COUNT(CASE WHEN status = \'complete\' THEN 1 END) as task_count, 
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(HOUR, created_at, completion_time) ELSE 0 END) as total_completion_hours,
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) % 60 ELSE 0 END) as total_completion_minutes,
                            FLOOR(SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) ELSE 0 END) / 60) as total_completion_hours_from_minutes,
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) ELSE 0 END) % 60 as total_completion_minutes_remainder,
                            SUM(COALESCE(idle_time, 0)) as total_idle_time,
                            SUM(
                                CASE 
                                    WHEN status = \'complete\' THEN TIMESTAMPDIFF(SECOND, created_at, completion_time) 
                                    ELSE TIMESTAMPDIFF(SECOND, created_at, NOW()) 
                                END
                            ) as total_work_seconds')
                ->groupBy('id_user', 'team_id');

            // Filter berdasarkan team jika dipilih
            if ($selectedTeam) {
                $tasksQuery->where('team_id', $selectedTeam);
            }

            // Filter berdasarkan bulan jika dipilih
            if ($selectedMonth) {
                $monthNumber = date('m', strtotime($selectedMonth));
                $tasksQuery->whereMonth('created_at', $monthNumber);
            }

            // Mengambil data task berdasarkan filter
            $tasks = $tasksQuery->get();
        }

        // Mengonversi waktu kerja dari detik ke format jam dan menit
        foreach ($tasks as $task) {
            $totalWorkMinutes = floor($task->total_work_seconds / 60);
            $task->work_hours = floor($totalWorkMinutes / 60);
            $task->work_minutes = $totalWorkMinutes % 60;

            // Format waktu idle
            if ($task->total_idle_time) {
                $idleHours = floor($task->total_idle_time / 60);
                $idleMinutes = $task->total_idle_time % 60;

                if ($idleHours > 0 && $idleMinutes == 0) {
                    $task->formatted_idle_time = "{$idleHours} jam";
                } else if ($idleHours) {
                    $task->formatted_idle_time = "{$idleHours} jam {$idleMinutes} menit";
                } else {
                    $task->formatted_idle_time = "{$idleMinutes} menit";
                }
            } else {
                $task->formatted_idle_time = "0 menit"; // Set null jika tidak ada idle time
            }

            // Format waktu penyelesaian dengan kata "jam" dan "menit"
            $completionHours = $task->total_completion_hours_from_minutes;
            $completionMinutes = $task->total_completion_minutes_remainder;

            if ($completionHours > 0) {
                $task->formatted_completion_time = "{$completionHours} jam {$completionMinutes} menit";
            } else {
                $task->formatted_completion_time = ($completionMinutes > 0) ? "{$completionMinutes} menit" : "0";
            }

            $task->productivity = $task->task_count + $task->total_tasks;

            // Menghitung jumlah tugas selesai tepat waktu untuk pengguna tertentu
            $onTimeTasks = Task::where('team_id', $task->team_id)
                ->where('id_user', $task->id_user)
                ->where('status', 'complete')
                ->whereColumn('completion_time', '<=', 'deadline')
                ->count();

            // Perhitungan efisiensi sebagai tugas selesai tepat waktu dibagi banyaknya tugas untuk pengguna tertentu
            $task->efficiency = $task->task_count > 0
                ? round(($onTimeTasks / max($task->productivity, 1)) * 100, 2)
                : 0;

            $task->accuracy = $task->task_count > 0
                ? round(($task->task_count / $task->productivity) * 100, 2)
                : 0;
        }

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        // Mengirim data ke view
        return view('reports.productivity', compact('teams', 'selectedTeam', 'selectedMonth', 'tasks', 'unreadNotificationsCount'));
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        $teamQuery = Team::query();

        // switch ($user->role->role_name) {
        //     case 'manager':
        //         $teamQuery->where('user_id', $user->id);
        //         break;
        //     case 'anggota':
        //         $teamQuery->whereHas('members', function ($query) use ($user) {
        //             $query->where('user_id', $user->id);
        //         });
        //         break;
        // }

        if ($user->role->hasPermission('package_leader') && !$user->role->hasPermission('package_full_reports')) {
            $teamQuery->where('user_id', $user->id);
        }

        if (!$user->role->hasPermission('package_leader') && $user->role->role_name != 'admin') {
            $teamQuery->whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $teams = $teamQuery->get();

        // Menentukan team yang dipilih, jika tidak ada, set null
        $teamId = $request->input('team_id') ? $request->input('team_id') : ($teams->count() > 0 ? $teams[0]->id : null);

        if ($user->role->hasPermission('package_leader')) {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                return $team->tasks->where('team_id', $teamId)->where('id_user', Auth::id());
            });
        } else {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                return $team->tasks->where('team_id', $teamId);
            });
        }

        // Mendapatkan filter yang dipilih
        $selectedTeam = $request->input('team_id') ? $request->input('team_id') : ($teams->count() ? $teams[0]->id : null);
        $selectedMonth = $request->get('month', null);

        if ($selectedTeam === null) {
            $tasks = collect(); // Mengatur data task menjadi kosong
        } else {
            // Mengambil task berdasarkan filter
            $tasksQuery = Task::with('assignee') // Menggunakan eager loading untuk assignee
                ->selectRaw('id_user, team_id, 
                            COUNT(CASE WHEN status = \'progress\' THEN 1 END) as total_tasks, 
                            COUNT(CASE WHEN status = \'complete\' THEN 1 END) as task_count, 
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(HOUR, created_at, completion_time) ELSE 0 END) as total_completion_hours,
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) % 60 ELSE 0 END) as total_completion_minutes,
                            FLOOR(SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) ELSE 0 END) / 60) as total_completion_hours_from_minutes,
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) ELSE 0 END) % 60 as total_completion_minutes_remainder,
                            SUM(COALESCE(idle_time, 0)) as total_idle_time,
                            SUM(
                                CASE 
                                    WHEN status = \'complete\' THEN TIMESTAMPDIFF(SECOND, created_at, completion_time) 
                                    ELSE TIMESTAMPDIFF(SECOND, created_at, NOW()) 
                                END
                            ) as total_work_seconds')
                ->groupBy('id_user', 'team_id');

            // Filter berdasarkan team jika dipilih
            if ($selectedTeam) {
                $tasksQuery->where('team_id', $selectedTeam);
            }

            // Filter berdasarkan bulan jika dipilih
            if ($selectedMonth) {
                $monthNumber = date('m', strtotime($selectedMonth));
                $tasksQuery->whereMonth('created_at', $monthNumber);
            }

            // Mengambil data task berdasarkan filter
            $tasks = $tasksQuery->get();
        }

        // Mengonversi dan memformat data seperti di index
        foreach ($tasks as $task) {
            $totalWorkMinutes = floor($task->total_work_seconds / 60);
            $task->work_hours = floor($totalWorkMinutes / 60);
            $task->work_minutes = $totalWorkMinutes % 60;

            // Format waktu idle
            if ($task->total_idle_time) {
                $idleHours = floor($task->total_idle_time / 60);
                $idleMinutes = $task->total_idle_time % 60;

                if ($idleHours > 0 && $idleMinutes == 0) {
                    $task->formatted_idle_time = "{$idleHours} jam";
                } else if ($idleHours) {
                    $task->formatted_idle_time = "{$idleHours} jam {$idleMinutes} menit";
                } else {
                    $task->formatted_idle_time = "{$idleMinutes} menit";
                }
            } else {
                $task->formatted_idle_time = "0 menit"; // Set null jika tidak ada idle time
            }

            // Format waktu penyelesaian dengan kata "jam" dan "menit"
            $completionHours = $task->total_completion_hours_from_minutes;
            $completionMinutes = $task->total_completion_minutes_remainder;

            if ($completionHours > 0) {
                $task->formatted_completion_time = "{$completionHours} jam {$completionMinutes} menit";
            } else {
                $task->formatted_completion_time = ($completionMinutes > 0) ? "{$completionMinutes} menit" : "0";
            }

            $task->productivity = $task->task_count + $task->total_tasks;

            // Menghitung jumlah tugas selesai tepat waktu untuk pengguna tertentu
            $onTimeTasks = Task::where('team_id', $task->team_id)
                ->where('id_user', $task->id_user)
                ->where('status', 'complete')
                ->whereColumn('completion_time', '<=', 'deadline')
                ->count();

            // Perhitungan efisiensi sebagai tugas selesai tepat waktu dibagi banyaknya tugas untuk pengguna tertentu
            $task->efficiency = $task->task_count > 0
                ? round(($onTimeTasks / max($task->productivity, 1)) * 100, 2)
                : 0;

            $task->accuracy = $task->task_count > 0
                ? round(($task->task_count / $task->productivity) * 100, 2)
                : 0;
        }

        // Generate PDF
        $pdf = PDF::loadView('reports.productivity_pdf', [
            'teams' => $teams,
            'tasks' => $tasks,
            'selectedTeam' => $selectedTeam,
            'selectedMonth' => $selectedMonth
        ]);

        return $pdf->download('Laporan_Produktivitas_Tim.pdf');
    }

    public function exportCsv(Request $request)
    {
        $user = Auth::user();

        // Filter teams based on the user's role
        $teamQuery = Team::query();
        // switch ($user->role->role_name) {
        //     case 'manager':
        //         $teamQuery->where('user_id', $user->id);
        //         break;
        //     case 'anggota':
        //         $teamQuery->whereHas('members', function ($query) use ($user) {
        //             $query->where('user_id', $user->id);
        //         });
        //         break;
        // }

        if ($user->role->hasPermission('package_leader') && !$user->role->hasPermission('package_full_reports')) {
            $teamQuery->where('user_id', $user->id);
        }

        if (!$user->role->hasPermission('package_leader') && $user->role->role_name != 'admin') {
            $teamQuery->whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $teams = $teamQuery->get();

        // Determine the selected team, default to the first team's ID or null if none
        $teamId = $request->input('team_id') ? $request->input('team_id') : ($teams->count() > 0 ? $teams[0]->id : null);

        // Fetch tasks based on user role and team selection
        if ($user->role->hasPermission('package_leader')) {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                return $team->tasks->where('team_id', $teamId)->where('id_user', Auth::id());
            });
        } else {
            $tasks = $teams->flatMap(function ($team) use ($teamId) {
                return $team->tasks->where('team_id', $teamId);
            });
        }

        // Get filter parameters for team and month
        $selectedTeam = $request->input('team_id') ? $request->input('team_id') : ($teams->count() ? $teams[0]->id : null);
        $selectedMonth = $request->get('month', null);

        // If no team selected, set tasks as an empty collection
        if ($selectedTeam === null) {
            $tasks = collect();
        } else {
            // Query to retrieve tasks with metrics
            $tasksQuery = Task::with('assignee')
                ->selectRaw('id_user, team_id, 
                            COUNT(CASE WHEN status = \'progress\' THEN 1 END) as total_tasks, 
                            COUNT(CASE WHEN status = \'complete\' THEN 1 END) as task_count, 
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(HOUR, created_at, completion_time) ELSE 0 END) as total_completion_hours,
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) % 60 ELSE 0 END) as total_completion_minutes,
                            FLOOR(SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) ELSE 0 END) / 60) as total_completion_hours_from_minutes,
                            SUM(CASE WHEN completion_time IS NOT NULL THEN TIMESTAMPDIFF(MINUTE, created_at, completion_time) ELSE 0 END) % 60 as total_completion_minutes_remainder,
                            SUM(COALESCE(idle_time, 0)) as total_idle_time,
                            SUM(
                                CASE 
                                    WHEN status = \'complete\' THEN TIMESTAMPDIFF(SECOND, created_at, completion_time) 
                                    ELSE TIMESTAMPDIFF(SECOND, created_at, NOW()) 
                                END
                            ) as total_work_seconds')
                ->groupBy('id_user', 'team_id');

            // Apply team filter
            if ($selectedTeam) {
                $tasksQuery->where('team_id', $selectedTeam);
            }

            // Apply month filter
            if ($selectedMonth) {
                $monthNumber = date('m', strtotime($selectedMonth));
                $tasksQuery->whereMonth('created_at', $monthNumber);
            }

            // Retrieve tasks with the applied filters
            $tasks = $tasksQuery->get();
        }

        // Map the tasks to an exportable format with consistent calculations
        $data = $tasks->map(function ($task) {
            // Convert work seconds to hours and minutes
            $workMinutes = floor($task->total_work_seconds / 60);
            $workHours = floor($workMinutes / 60);
            $workMinutesRemainder = $workMinutes % 60;

            // Format idle time

            if ($task->total_idle_time >= 60) {
                $idleHours = $task->total_idle_time / 60;
                $idleMinutes = $idleHours % 60;
                $task->formatted_idle_time = "{$idleHours} jam {$idleMinutes} menit";
            } else {
                $idleMinutes = $task->total_idle_time % 60;

                $task->formatted_idle_time = "{$idleMinutes} menit";
            }

            $formattedIdleTime = $task->formatted_idle_time;

            // Calculate productivity
            $productivity = $task->task_count + $task->total_tasks;

            $onTimeTasks = Task::where('team_id', $task->team_id)
                ->where('id_user', $task->id_user)
                ->where('status', 'complete')
                ->whereColumn('completion_time', '<=', 'deadline')
                ->count();

            // Calculate efficiency as a percentage of completed tasks vs total tasks
            $efficiency = $task->task_count > 0
                ? round((($onTimeTasks / $productivity) * 100), 2)
                : 0;

            // Calculate accuracy as a percentage of completed tasks vs total tasks
            $accuracy = $task->task_count > 0
                ? round(($task->task_count / $productivity) * 100, 2)
                : 0;

            return [
                'Nama Anggota' => $task->assignee ? $task->assignee->username : 'Tidak Ada Anggota',
                'Tugas Diselesaikan' => $task->task_count,
                'Produktivitas' => $productivity,
                'Efisiensi' => number_format($efficiency, 2) . ' %', // Format efficiency
                'Akurasi' => number_format($accuracy, 2) . ' %', // Format accuracy
                'Tugas Dikerjakan' => $task->total_tasks,
                'Waktu Kerja' => $workHours ? "{$workHours} jam {$workMinutesRemainder} menit" : "{$workMinutesRemainder} menit", // Format work time
                'Waktu Idle' => $formattedIdleTime, // Format idle time
            ];
        });

        // Define the CSV file name and headers
        $filename = "laporan_tim.csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        // Callback to stream the CSV content
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            // Write the CSV header
            if ($data->isNotEmpty()) {
                fputcsv($file, array_keys($data->first()));
            } else {
                fputcsv($file, [
                    'Nama Anggota',
                    'Tugas Diselesaikan',
                    'Produktivitas',
                    'Efisiensi',
                    'Akurasi',
                    'Tugas Dikerjakan',
                    'Waktu Kerja',
                    'Waktu Idle'
                ]);
            }

            // Write each row of task data
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        // Return the response with the CSV data stream
        return response()->stream($callback, 200, $headers);
    }
}
