<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
use App\Models\Notification; // Impor model Notification
use Carbon\Carbon;

class CheckDeadlines extends Command
{
    protected $signature = 'deadlines:check';
    protected $description = 'Check tasks with deadlines 1 day away and notify users';

    public function handle()
    {
        // Ambil tugas yang memiliki deadline besok
        $tasks = Task::whereDate('deadline', '=', Carbon::tomorrow())->get();

        foreach ($tasks as $task) {
            // Cari user terkait
            $user = User::find($task->id_user);

            if ($user) {
                // Simpan notifikasi ke database
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Deadline Reminder',
                    'message' => "Deadline tugas <a href='" . route('tasks.show', ['id' => $task->id]) . "'>{$task->task_name}</a> tersisa dikit lagi",
                    'type' => 'message',
                    'status' => 'unread',
                ]);
            }
        }

        $this->info('Deadline reminders sent successfully.');
    }
}
