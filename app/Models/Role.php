<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Role extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'roles';

    protected $fillable = [
        'role_name'
    ];


    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
