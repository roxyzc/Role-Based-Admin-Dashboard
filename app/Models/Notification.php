<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'status'
    ];

    // Relationship to User (Assuming a user can have many notifications)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
