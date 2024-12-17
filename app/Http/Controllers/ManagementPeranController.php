<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ManagementPeranController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $limit = (int) $request->input('limit', 10);
        $search = $request->input('search', '');

        $maxPage = 100;
        $maxLimit = 50;

        $page = min(max($page, 1), $maxPage);
        $limit = min(max($limit, 1), $maxLimit);

        $roles = Role::withCount('users')
            ->when($search, function ($query) use ($search) {
                $query->where('role_name', 'LIKE', "%$search%");
            })
            ->paginate($limit, ['*'], 'page', $page);

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        return view('admin.management_peran', [
            'roles' => $roles,
            'total_roles' => $roles->total(),
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'limit' => $limit,
            'currentPage' => $roles->currentPage(),
            'totalPages' => $roles->lastPage(),
        ]);
    }

    public function deletePeran(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        if ($role->users()->exists()) {
            return redirect()->back()->with('error', 'Peran tidak dapat dihapus karena masih digunakan oleh pengguna.');
        }

        $role->delete();

        return redirect()->route('admin.management_peran')->with('success', 'Peran berhasil dihapus!');
    }


    public function index_add()
    {
        $usersWithoutRole = User::whereNull('role_id')->get();

        $roles = Role::where('role_name', '!=', 'admin')->get();

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('admin.add_user_role', [
            'users' => $usersWithoutRole,
            'roles' => $roles,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'role_id' => 'required|exists:roles,id',
        ], [
            'role.required' => 'Role harus diisi',
            'username.required' => 'Username harus diisi',
        ]);

        $username = $request->input('username');
        $roleId = $request->input('role_id');

        $user = User::where('username', $username)->first();

        if ($user) {
            $user->role_id = $roleId;
            $user->save();

            return redirect()->route('admin.management_peran.detail', ['role' => $roleId])
                ->with('success', 'Role pengguna berhasil diperbarui!');
        } else {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }
    }

    public function detail(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $search = $request->input('search', '');

        $maxPage = 100;
        $maxLimit = 50;

        $page = min(max($page, 1), $maxPage);
        $limit = min(max($limit, 1), $maxLimit);

        $usersQuery = $role->users()->when($search, function ($query) use ($search) {
            return $query->where('username', 'like', "%$search%");
        });

        $totalUsers = $usersQuery->count();

        $users = $usersQuery->paginate($limit, ['*'], 'page', $page);

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('admin.detail_peran', [
            'role' => $role,
            'users' => $users,
            'search' => $search,
            'limit' => $limit,
            'totalUsers' => $totalUsers,
            'currentPage' => $users->currentPage(),
            'totalPages' => $users->lastPage(),
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    public function editUserRole(Role $role, User $user)
    {

        if ($role->role_name == 'admin') {
            $roles = Role::all();
        } else {
            $roles = Role::where('role_name', '!=', 'admin')->get();
        }

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('admin.edit_peran', compact('role', 'user', 'roles', 'unreadNotificationsCount'));
    }

    public function updateUserRole(Request $request, Role $role, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ], [
            'role.required' => 'Role harus diisi',
        ]);

        if (Auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa memperbarui peran Anda sendiri!');
        }

        $user->update([
            'role_id' => $request->role_id
        ]);

        return redirect()->route('admin.management_peran.detail', $role->id)
            ->with('success', 'Role pengguna berhasil diperbarui!');
    }

    public function deleteUserRole(Request $request, Role $role, User $user)
    {
        if (Auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus peran Anda sendiri!');
        }

        $user->update(['role_id' => null]);

        return redirect()->route('admin.management_peran.detail', $role->id)
            ->with('success', 'Peran pengguna berhasil dihapus!');
    }
}
