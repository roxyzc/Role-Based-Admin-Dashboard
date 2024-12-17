<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'description',
        'team_id',
        'id_user',
        'status',
        'file',
        'priority',
        'deadline',
        'idle_time',
        'completion_time'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
