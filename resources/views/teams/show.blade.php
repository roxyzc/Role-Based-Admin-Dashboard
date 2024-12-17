@extends('layout.main')

@section('title', 'Detail Tim')

@section('content')
<style>
    .material-icons {
        display: inline-block;
    }

    .btn-link .material-icons {
        vertical-align: middle;
    }

    .form-control.text-white::placeholder {
        color: white;
    }
</style>

<div class="flex-grow-1 d-flex flex-column"> 
    <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
        <a href="{{ route('teams.index') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
            <span class="text-muted">Home &gt;</span> 
            <span class="text-muted ms-2">Beban Kerja &gt;</span>
            <span class="text-muted ms-2">Detail Tim</span>
        </div>
    </div>

    @if(Auth::user()->role->hasPermission('package_create_task'))
        <div class="button-container mt-3 mb-3" style="display: flex; justify-content: flex-end; margin-right: 20px;">
            <a href="{{ route('teams.tasks.create', $team->id) }}" class="btn btn-primary" style="background-color: #19508C;">Berikan Tugas</a>
        </div>
    @endif

    <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="p-3 d-flex justify-content-between align-items-center bg-white">
        <div class="d-flex align-items-center gap-2">
        <span class="fs-5">Tim</span>
        <span class="badge bg-secondary">{{ request('data') == 'tugas'? $totalTasks : $totalMembers }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
        <span>Show</span>
        <form method="GET" class="d-flex align-items-center gap-2">
            <select name="limit" class="form-select w-auto">
                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
            </select>
            <select name="data" class="form-select w-auto">
                <option value="anggota" {{ request('data') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                <option value="tugas" {{ request('data') == 'tugas' ? 'selected' : '' }}>Tugas</option>
            </select>
            <input 
                type="text" 
                name="search" 
                class="form-control w-auto"
                value="{{ request('search') }}" 
                placeholder="Search..."
            />
            <button type="submit" class="form-control w-auto" style="background: none; border: none; padding: 0;">
                <i class="bi bi-funnel" style="font-size: 28px; color: #A0A0A0;"></i>
            </button>
        </form>
        </div>
    </div>

    <table class="table table-bordered mb-0" style="background-color: #F7F6FE">
        <thead class="table-primary" style="background-color: #CFE4FB">
        <tr>
            <th scope="col" class="text-center">No</th>
            @if(request('data') == 'tugas')
                <th scope="col" class="text-center">Tugas</th>
            @else
                <th scope="col" class="text-center">Nama Anggota</th>
            @endif
            <th scope="col" class="text-center">Tanggal Dibuat</th>
            <th scope="col" class="text-center">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @if(request('data') == 'tugas')
            @if($tasks->count() > 0)
                @foreach($tasks as $index => $task)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $task->task_name }}</td> 
                    <td class="text-center">{{ $task->created_at->format('d M Y H:i:s') }}</td>
                    <td class="text-center">
                        @if(Auth::user()->role->hasPermission('package_delete_member'))
                            <button type="button" class="btn btn-link btn-sm text-danger p-0 mx-1" title="Hapus Tugas" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteForm('task', {{ $task->id }})">
                                <i class="fas fa-trash-alt" style="font-size: 20px;"></i>
                            </button>
                        @endif

                        <a href="{{ route('tasks.show', $task->id)}}" class="btn btn-link text-primary p-0"><i class="material-icons">search</i></a>
                    </td>
                </tr>

                <form id="deleteTaskForm-{{ $task->id }}" method="POST" action="{{ route('teams.removeTask', $task->id) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center" style="color: red;">Data tidak ditemukan</td>
                </tr>
            @endif
        @else
            @if($members->count() > 0)
                @foreach($members as $index => $member)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $member->username }}</td> 
                        <td class="text-center">{{ $member->pivot->created_at->format('d M Y H:i:s') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-link btn-sm text-danger p-0 mx-1" title="Hapus Anggota" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteForm('member', {{ $team->id }}, {{ $member->id }})">
                                <i class="fas fa-trash-alt" style="font-size: 20px;"></i>
                            </button>

                            <a href="{{ route('workload', $member->id)}}" class="btn btn-link text-primary p-0"><i class="material-icons">search</i></a>
                        </td>
                    </tr>

                    <form id="deleteMemberForm-{{ $team->id }}-{{ $member->id }}" method="POST" action="{{ route('teams.removeMember', ['team' => $team->id, 'user' => $member->id]) }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center" style="color: red;">Data tidak ditemukan</td>
                </tr>
            @endif
        @endif
    </table>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center border-0">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                </div>
                <div class="modal-body text-center border-bottom pb-3">
                    Apakah Anda yakin ingin menghapus ini?
                </div>
                <div class="modal-footer justify-content-end border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
        
    <div class="d-flex justify-content-center my-3">
        <nav>
            <ul class="pagination" style="display: flex; list-style: none; padding: 0; margin: 0;">
                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}" style="margin: 0 5px;">
                    <a class="page-link" style="text-decoration: none; color: {{ $currentPage == 1 ? '#ADB5BD' : '#19508C' }}; background: none; border: none; pointer-events: {{ $currentPage == 1 ? 'none' : 'auto' }};" href="?page={{ $currentPage - 1 }}&limit={{ $limit }}&search={{ request('search') }}">
                        <span style="margin-right: 5px;">&larr;</span> Previous
                    </a>
                </li>

                @for ($i = 1; $i <= $totalPages; $i++)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}" style="margin: 0 5px;">
                        <a class="page-link" style="text-decoration: none; padding: 0.5rem 1rem; border: 1px solid #ADB5BD; border-radius: 0.5rem; background-color: {{ $i == $currentPage ? '#19508C' : 'transparent' }}; color: {{ $i == $currentPage ? '#FFFFFF' : '#19508C' }};" href="?page={{ $i }}&limit={{ $limit }}&search={{ request('search') }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}" style="margin: 0 5px;">
                    <a class="page-link" style="text-decoration: none; color: {{ $currentPage == $totalPages ? '#ADB5BD' : '#19508C' }}; background: none; border: none; pointer-events: {{ $currentPage == $totalPages ? 'none' : 'auto' }};" href="?page={{ $currentPage + 1 }}&limit={{ $limit }}&search={{ request('search') }}">
                        Next <span style="margin-left: 5px;">&rarr;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</div>
</div>

<script>
   function setDeleteForm(type, teamId, memberId = null) {
        let form;
        let deleteButton = document.getElementById('confirmDeleteBtn');

        if (type === 'task') {
            form = document.getElementById(`deleteTaskForm-${teamId}`);
        } else if (type === 'member') {
            form = document.getElementById(`deleteMemberForm-${teamId}-${memberId}`);
        }

        deleteButton.onclick = function() {
            form.submit();
        };
    }
</script>
@endsection
