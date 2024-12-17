<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permissions;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function create()
    {
        $permissions = Permissions::all();

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('roles.create', compact('permissions', 'unreadNotificationsCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => [
                'required',
                'string',
                'min:2',
                'max:20',
                'regex:/^[a-zA-Z ]+$/',
                'unique:roles,role_name',
            ],
            'permissions' => 'required|array|min:1',
        ], [
            'role_name.required' => 'Nama role wajib diisi.',
            'role_name.string' => 'Nama role harus berupa teks.',
            'role_name.min' => 'Nama role minimal :min karakter.',
            'role_name.max' => 'Nama role maksimal :max karakter.',
            'role_name.regex' => 'Nama role hanya boleh berisi huruf dan spasi.',
            'role_name.unique' => 'Nama role sudah digunakan',
            'permissions.required' => 'Pilih setidaknya satu hak akses.',
            'permissions.array' => 'Hak akses harus berupa array.',
            'permissions.min' => 'Pilih setidaknya satu hak akses.',
        ]);

        $role_name = preg_replace('/\s+/', ' ', trim($request->role_name));

        $role = Role::create([
            'role_name' => $role_name,
        ]);

        $role->permissions()->attach($request->permissions);

        return redirect()->back()->with('success', 'Role berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        if ($role->role_name == 'admin') {
            return abort(403, 'Unauthorized action.');
        }

        $permissions = Permissions::all();

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('roles.permissions', compact('role', 'permissions', 'unreadNotificationsCount'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => [
                'required',
                'string',
                'min:2',
                'max:20',
                'regex:/^[a-zA-Z ]+$/',
                'unique:roles,role_name,' . $id,
            ],
            'current_permissions' => 'nullable|string',
        ], [
            'role_name.required' => 'Nama role wajib diisi.',
            'role_name.string' => 'Nama role harus berupa teks.',
            'role_name.min' => 'Nama role minimal :min karakter.',
            'role_name.max' => 'Nama role maksimal :max karakter.',
            'role_name.regex' => 'Nama role hanya boleh berisi huruf dan spasi.',
            'role_name.unique' => 'Nama role sudah digunakan',
        ]);

        $role = Role::findOrFail($id);

        $permissions = explode(',', $request->input('current_permissions'));

        $permissions = array_filter($permissions, function ($permission) {
            return !empty($permission);
        });

        if (empty($permissions)) {
            $permissions = [];
        }

        $role_name = preg_replace('/\s+/', ' ', trim($request->role_name));

        $role->permissions()->sync($permissions);

        $role->role_name = $role_name;
        $role->save();

        return redirect()->back()->with('success', 'Hak akses berhasil diperbarui!');
    }
}
