@extends('layout.main')

@section('title', 'Manajemen Peran Admin')

@section('content')
<style>
    .btn-link {
      font-size: 16px;
      text-decoration: none !important;
      color: #6c757d;
      font-weight: 400;
      border: none;
      background: transparent;
      padding: 0;
    }

    .btn-link:hover {
      text-decoration: none !important;
      color: #6c757d;
    }

    .btn-link .material-icons {
      font-size: 14px;
      vertical-align: middle;
    }

    .pagination .page-item .page-link {
      padding: 8px 16px;
      margin: 0 4px;
    }

    .form-control.text-white::placeholder {
      color: white;
    }

    .action-icons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .action-icons a,
    .action-icons button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: inherit;
        border: none;
        background: none;
        padding: 0;
    }

    .action-icons i {
        font-size: 18px; 
    }
  </style>

<div class="d-flex">
    <div class="flex-grow-1 d-flex flex-column" style="margin-left: 0;">
      <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
        <a href="{{ route('admin.management_peran')  }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
          <span class="text-muted">Home &gt;</span> 
          <span class="text-muted ms-2">Manajemen Peran</span>
          <span class="text-muted ms-2">&gt; Detail Anggota</span>
        </div>
      </div>
    
      <div class="button-container mt-3 mb-3" style="display: flex; justify-content: flex-end; margin-right: 20px; gap:5px; border-radius:8px;">
        <a href="{{ route('admin.management_peran.add_user') }}" class="btn btn-primary" style="background-color: #19508C;">Tambah Peran Pengguna</a>
      </div>

      <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
    <div class="p-2 d-flex justify-content-between align-items-center bg-white">
        <div class="d-flex align-items-center gap-2">
            <span class="fs-5">{{ $role->role_name }}</span>
            <span class="badge bg-secondary">{{ $totalUsers }}</span>
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

        <table class="table table-bordered mb-" style="background-color: #F7F6FE">
        <thead class="table-primary" style="background-color: #CFE4FB">
            <tr>
              <th scope="col" class="text-center">No</th>
              <th scope="col" class="text-center">Username</th>
              <th scope="col" class="text-center">Peran</th>
              <th scope="col" class="text-center">Tanggal Bergabung</th>
              @if($role->role_name != 'admin')
                <th scope="col" class="text-center">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @if($users->count() > 0)
            @foreach($users as $index => $user)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="text-center align-middle">{{ $user->username }}</td>
                    <td class="text-center align-middle">
                      <span class="badge" 
                      style="background-color: 
                          @if($role->role_name == 'admin') 
                              #EBF9F1; 
                          @elseif($role->hasPermission('package_leader')) 
                              #FEF2E5; 
                          @else 
                              #FBE7E8; 
                          @endif
                      color: 
                          @if($role->role_name == 'admin') 
                              #1F9254;
                          @elseif($role->hasPermission('package_leader')) 
                              #CD6200; 
                          @else 
                              #A30D11;  
                          @endif;
                          padding: 0.6rem; 
                          border-radius: 0.5rem;">
                      {{ $role->role_name }}
                    </td>
                    <td class="text-center align-middle">{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                    @if($role->role_name != 'admin')
                      <td class="text-center align-middle">
                      @if(Auth()->id() != $user->id)
                      <div class="action-icons">
                          <a href="{{ route('admin.management_peran.edit_user_role', ['role' => $role->id, 'user' => $user->id]) }}" class="text-primary">
                              <i class="material-icons">edit</i>
                          </a>
                          <button type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteForm({{ $user->id }})">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                      </div>

                      <form id="deleteForm-{{ $user->id }}" method="POST" action="{{ route('admin.management_peran.delete_user_role', ['role' => $role->id, 'user' => $user->id]) }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                      </form>
                      @endif
                      </td>
                    @endif
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center" style="color: red;">Data tidak ditemukan</td>
                </tr>
            @endif  
          </tbody>
        </table>

        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header d-flex justify-content-center border-0">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
            </div>
            <div class="modal-body text-center border-bottom pb-3">
                Apakah Anda yakin ingin menghapus peran pengguna ini?
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
    function setDeleteForm(userId) {
        let form = document.getElementById('deleteForm-' + userId);
        let deleteButton = document.getElementById('confirmDeleteBtn');

        deleteButton.onclick = function() {
            form.submit();
        };
    }
  </script>

@endsection