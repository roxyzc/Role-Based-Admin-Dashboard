<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permissions;

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

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class, 'role_permission', 'role_id', 'permission_id');
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions->contains('name', $permissionName);
    }
}
