@extends('layout.main')

@section('title', 'Manajemen Peran')

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
  </style>

<div class="d-flex">
    <div class="flex-grow-1 d-flex flex-column" style="margin-left: 0;">
      <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
        <a href="{{ route('dashboard') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
          <span class="text-muted">Home &gt;</span> 
          <span class="text-muted ms-2">Manajemen Peran</span>
        </div>
      </div>

      <div class="button-container mt-3 mb-3" style="display: flex; justify-content: flex-end; margin-right: 20px; gap:5px; border-radius:8px;">
        <a href="{{ route('roles.create') }}" class="btn text-white" style="background-color: #19508C;">Tambah Peran</a>
      </div>
      
      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-4 mt-2" role="alert">
            <ul class="mb-0 list-unstyled">
                <li class="small">{{ session('error') }}</li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      <div class="bg-white rounded-3 shadow mx-4 mt-3 overflow-hidden">
        <div class="p-3 d-flex justify-content-between align-items-center bg-white">
            <div class="d-flex align-items-center gap-2">
            <span class="fs-5">Peran</span>
            <span class="badge bg-secondary">{{ $total_roles }}</span>
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
                <th scope="col" class="text-center">No</th>
                <th scope="col" class="text-center">Peran</th>
                <th scope="col" class="text-center">Jumlah Anggota</th>
                <th scope="col" class="text-center">Tanggal Dibuat</th>
                <th scope="col" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($roles as $index => $role)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
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
                    </span>
                    </td>
                    <td class="text-center align-middle">{{ $role->users_count }}</td>
                    <td class="text-center align-middle">{{ $role->updated_at->format('Y-m-d H:i:s') }}</td>
                    <td class="text-center align-middle">
                    @if ($role->role_name != 'admin')
                      <a href="{{ route('roles.edit', $role->id) }}"  class="btn btn-link text-warning p-0 mx-1" title="Edit Tim">
                        <i class="material-icons" style="font-size: 20px;">edit</i>
                      </a>
                      <button type="button" class="btn btn-link text-danger p-0 mx-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" 
                              onclick="setDeleteForm({{ $role->id }})" title="Hapus Peran">
                          <i class="fas fa-trash-alt" style="font-size: 15px;"></i>
                      </button>
                    @endif
                      <a href="{{ route('admin.management_peran.detail', $role->id) }}" class="btn btn-link text-primary p-0">
                        <i class="material-icons" style="font-size: 22px;">search</i>
                      </a>
                    </td>
                </tr>
                
                <form id="deleteForm-{{ $role->id }}" method="POST" action="{{ route('admin.management_peran.delete', ['roleId' => $role->id]) }}" style="display: none;">
                  @csrf
                  @method('DELETE')
                </form>
            @endforeach        
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
          Apakah Anda yakin ingin menghapus peran ini?
      </div>
      <div class="modal-footer justify-content-end border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
      </div>
      </div>
  </div>
</div>

<script>
  function setDeleteForm(roleId) {
      let form = document.getElementById('deleteForm-' + roleId);
      let deleteButton = document.getElementById('confirmDeleteBtn');

      deleteButton.onclick = function() {
          form.submit();
      };
  }
</script>
@endsection
