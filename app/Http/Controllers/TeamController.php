<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeamController extends Controller
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

        $teamsQuery = Team::withCount('teamMembers')->latest()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });

        if (Auth::user()->role->role_name == 'admin') {
            $teamsQuery->with('creator');
        }

        if (Auth::user()->role->role_name != 'admin') {
            $teamsQuery->where('user_id', Auth::user()->id);
        }

        $totalTeams = $teamsQuery->count();

        $teams = $teamsQuery->paginate($limit, ['*'], 'page', $page);

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('teams.index', [
            'teams' => $teams,
            'search' => $search,
            'limit' => $limit,
            'totalTeams' => $totalTeams,
            'currentPage' => $teams->currentPage(),
            'totalPages' => $teams->lastPage(),
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    public function create()
    {
        $users = User::all();

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('teams.create', compact('users', 'unreadNotificationsCount'));
    }

    public function destroyTeam(Request $request, $teamId)
    {
        $team = Team::findOrFail($teamId);

        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Tim berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s]+$/',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.min' => 'Nama harus memiliki minimal 2 karakter.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
        ]);

        $name = preg_replace('/\s+/', ' ', trim(strtolower($request->name)));

        $findTeamExist = Team::where('user_id', Auth::user()->id)
            ->where('name', $name)
            ->exists();

        if ($findTeamExist) {
            return redirect()->back()->with('error', 'Tim dengan nama tersebut sudah ada.');
        }

        $countTeamUser = Team::where('user_id', Auth::user()->id)->count();

        if ($countTeamUser >= 3) {
            return redirect()->back()->with('error', 'Anda tidak dapat membuat lebih dari 3 tim.');
        }

        $team = Team::create([
            'name' => $name,
            'user_id' => Auth::user()->id,
            'created_date' => now(),
        ]);

        if ($request->has('user_id')) {
            foreach ($request->user_id as $user_id) {
                TeamMember::create([
                    'team_id' => $team->id,
                    'user_id' => $user_id,
                ]);
            }
        }

        return redirect()->route('teams.index')->with('success', 'Tim berhasil dibuat.');
    }

    public function show(Team $team, Request $request)
    {
        $user = Auth::user();
        $role = $user->role->role_name;

        if ($role === 'manager') {
            if ($team->user_id !== $user->id) {
                abort(403, 'Akses ditolak');
            }
        }

        $limit = (int) $request->input('limit', 10);
        $page = (int) $request->input('page', 1);
        $search = $request->input('search', '');
        $data = $request->input('data', 'anggota');

        $maxPage = 100;
        $maxLimit = 50;

        $limit = min(max($limit, 1), $maxLimit);
        $page = min(max($page, 1), $maxPage);

        if ($data == 'tugas') {
            $tasksQuery = $team->tasks()->when($search, function ($query) use ($search) {
                $query->where('tasks.task_name', 'like', "%$search%");
            });

            $totalTasks = $tasksQuery->count();

            $tasks = $tasksQuery->paginate($limit, ['*'], 'page', $page);

            $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

            return view('teams.show', [
                'team' => $team,
                'tasks' => $tasks,
                'totalTasks' => $totalTasks,
                'limit' => $limit,
                'currentPage' => $tasks->currentPage(),
                'totalPages' => $tasks->lastPage(),
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        } else {
            $membersQuery = $team->members()->when($search, function ($query) use ($search) {
                $query->where('users.username', 'like', "%$search%");
            });

            $totalMembers = $membersQuery->count();
            $members = $membersQuery->paginate($limit, ['*'], 'page', $page);

            $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

            return view('teams.show', [
                'team' => $team,
                'members' => $members,
                'totalMembers' => $totalMembers,
                'limit' => $limit,
                'currentPage' => $members->currentPage(),
                'totalPages' => $members->lastPage(),
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        }
    }

    public function showAddMemberForm($teamId)
    {
        $team = Team::findOrFail($teamId);

        $user = Auth::user();
        $role = $user->role;

        if ($role->hasPermission('package_leader')) {
            if ($team->user_id !== $user->id) {
                abort(403, 'Akses ditolak');
            }
        }

        $users = User::whereNotIn('id', $team->members->pluck('id'))
            ->whereHas('role', function ($query) {
                $query->where('role_name', '!=', 'admin');
            })
            ->whereDoesntHave('role.permissions', function ($query) {
                $query->where('name', 'package_leader');
            })
            ->get();

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('teams.add-member', compact('team', 'users', 'unreadNotificationsCount'));
    }

    public function addMember(Request $request, $teamId)
    {
        $team = Team::findOrFail($teamId);

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $team->members()->attach($request->user_id);

        return redirect()->route('teams.show', $teamId)->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function storeMember(Request $request, Team $team)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Menambahkan anggota baru ke tim
        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('teams.show', $team->id)->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function editMember(TeamMember $member)
    {
        $users = User::all();

        return view('teams.edit-member', compact('member', 'users'));
    }

    public function updateMember(Request $request, TeamMember $member)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $member->update([
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('teams.show', $member->team_id)->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroyMember(TeamMember $member)
    {
        $member->delete();

        return redirect()->route('teams.show', $member->team_id)->with('success', 'Anggota berhasil dihapus.');
    }

    public function assignTask(Team $team)
    {
        return view('teams.assignTask', compact('team'));
    }


    public function removeMember(Team $team, User $user)
    {
        $teamTasks = $team->tasks()->where('id_user', $user->id)->get();

        foreach ($teamTasks as $task) {
            $task->delete();
        }

        $team->members()->detach($user);
        return redirect()->route('teams.show', $team->id)->with('success', 'Anggota berhasil dihapus');
    }

    public function edit(Team $team)
    {
        $user = Auth::user();
        $role = $user->role->role_name;

        if ($role === 'manager') {
            if ($team->user_id !== $user->id) {
                abort(403, 'Akses ditolak');
            }
        }

        $unreadNotificationsCount = Notification::where('user_id', Auth::id())->where('status', 'unread')->count();

        return view('teams.edit', compact('team', 'unreadNotificationsCount'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s]+$/',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.min' => 'Nama harus memiliki minimal :min karakter.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
        ]);

        $name = preg_replace('/\s+/', ' ', trim(strtolower($request->name)));

        $findTeamExist = Team::where('user_id', Auth::user()->id)
            ->where('name', $name)
            ->exists();

        if ($findTeamExist) {
            return redirect()->back()->with('error', 'Tim dengan nama tersebut sudah ada.');
        }

        $team->update([
            'name' => $name,
        ]);

        return redirect()->route('teams.index')->with('success', 'Tim berhasil diperbarui.');
    }
}
