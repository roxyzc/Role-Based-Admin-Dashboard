@extends('layout.main')

@section('title', 'Beban kerja')

@section('content')
<style>
    .material-icons {
        line-height: 1; 
        display: inline-block; 
    }

    .btn-link .material-icons {
        vertical-align: middle;
    }

    .pagination .page-item .page-link {
        padding: 8px 16px;
        margin: 0 4px;
    }

    .form-control.text-white::placeholder {
        color: white;
    }
    
</style>
<div class="d-flex">

<div class="flex-grow-1 d-flex flex-column">
    <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
        <a href="{{ route('dashboard')}}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
            <span class="text-muted">Home &gt;</span> 
            <span class="text-muted ms-2">Beban Kerja</span>
        </div>
    </div>

    @if(Auth::user()->role->hasPermission('package_leader'))
        <div class="button-container mt-3 mb-3" style="display: flex; justify-content: flex-end; margin-right: 20px; gap:5px; border-radius:8px;">
            <a href="{{ route('teams.create') }}" class="btn btn-primary" style="background-color: #19508C;">Tambah Tim</a>
        </div>
    @endif

    <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden">
    
    <div class="p-3 d-flex justify-content-between align-items-center bg-white">
        <div class="d-flex align-items-center gap-2">
        <span class="fs-5">Tim</span>
        <span class="badge bg-secondary">{{ $totalTeams }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
        <span>Show</span>
        <form method="GET" class="d-flex align-items-center gap-2">
            <select name="limit" class="form-select w-auto">
                <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
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
            <th scope="col" class="text-center align-middle">No</th>
            <th scope="col" class="text-center align-middle">Nama Tim</th>
            @if(Auth::user()->role->role_name == 'admin')
                <th scope="col" class="text-center align-middle">Pembuat</th>
            @endif
            <th scope="col" class="text-center align-middle">Jumlah Anggota</th>
            <th scope="col" class="text-center align-middle">Tanggal Dibuat</th>
            <th scope="col" class="text-center align-middle">Aksi</th>
        </tr>
        </thead>
        <tbody>
            @if($teams->count() > 0)
            @foreach ($teams as $index => $team)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="text-center align-middle">{{ ucwords($team->name) }}</td>
                    @if(Auth::user()->role->role_name == 'admin')
                        <td class="text-center align-middle">{{ $team->creator->username }}</td>
                    @endif
                    <td class="text-center align-middle">{{ $team->team_members_count }}</td>
                    <td class="text-center align-middle">{{ $team->created_date->format('d M Y H:i:s') }}</td>
                    <td class="text-center align-middle">
                        <a href="{{ route('teams.show', $team->id) }}" class="btn btn-link btn-sm text-primary p-0 mx-1" title="Lihat Detail">
                            <i class="material-icons" style="font-size: 20px;">search</i>
                        </a>

                        @if(Auth::user()->role->hasPermission('package_add_member'))
                            <a href="{{ route('teams.addMember', $team->id) }}" class="btn btn-link btn-sm text-success p-0 mx-1" title="Tambah Anggota">
                                <i class="material-icons" style="font-size: 20px;">person_add</i>
                            </a>
                        @endif

                        @if(Auth::user()->role->hasPermission('package_edit_team'))
                        <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-link btn-sm text-warning p-0 mx-1" title="Edit Tim">
                            <i class="material-icons" style="font-size: 20px;">edit</i>
                        </a>
                        @endif

                        @if(Auth::user()->role->hasPermission('package_delete_team'))
                            <button type="button" class="btn btn-link btn-sm text-danger p-0 mx-1" title="Hapus Tim" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteForm({{ $team->id }})">
                                <i class="fas fa-trash-alt" style="font-size: 20px;"></i>
                            </button>
                        @endif
                    </td>

                </tr>

                <form id="deleteForm-{{ $team->id }}" method="POST" action="{{ route('teams.destroy', $team->id) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center" style="color: red;">Data tidak ditemukan</td>
                </tr>
            @endif  
        </tbody>
    </table>

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

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header d-flex justify-content-center border-0">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
        </div>
        <div class="modal-body text-center border-bottom pb-3">
            Apakah Anda yakin ingin menghapus team ini?
        </div>
        <div class="modal-footer justify-content-end border-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
        </div>
        </div>
    </div>
</div>

<script>
    function setDeleteForm(teamId) {
        let form = document.getElementById('deleteForm-' + teamId);
        let deleteButton = document.getElementById('confirmDeleteBtn');

        deleteButton.onclick = function() {
            form.submit();
        };
    }
</script>
@endsection