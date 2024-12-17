{{-- @extends('layout.main')

@section('title', 'Tambah Role')
<style>
    .badge-custom {
        background-color: #0d6efd;
        color: #fff;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        padding: 0.35em 0.65em; 
        display: inline-flex;
        align-items: center;
        gap: 0.5em;
    }

    .delete-icon {
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
        margin-left: 8px;
    }

    .delete-icon:hover {
        color: red; 
    }
</style>

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Tambah Role Baru</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="role_name" class="form-label">Nama Role</label>
                    <input type="text" class="form-control" id="role_name" name="role_name" required>
                </div>

                <div class="mb-4">
                    <label for="permissions" class="form-label">Tambah Hak Akses</label>
                    <select name="permissions[]" id="permissions" class="form-control" multiple="multiple" required>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Tambah Role</button>
            </form>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
        $('#permissions').select2({
            placeholder: "Tambah Hak Akses",
            allowClear: true,
            width: '100%'
        });
   });
</script>
@endsection --}}

@extends('layout.main')

@section('title', 'Tambah Peran')

@section('content')
<style>
  .badge-custom {
    background-color: #19508C;
    color: #fff;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    padding: 0.35em 0.65em; 
    display: inline-flex;
    align-items: center;
    gap: 0.5em;
  }

  .delete-icon {
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    margin-left: 8px;
  }

  .delete-icon:hover {
    color: red; 
  }
</style>

<div class="d-flex">
  <div class="flex-grow-1 d-flex flex-column">
    <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
      <a href="{{ route('admin.management_peran') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
      <div class="d-flex align-items-center">
        <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home &gt;</a>
        <a href="{{ route('admin.management_peran') }}" class="text-muted text-decoration-none ms-2">Management Peran &gt;</a>
        <a href="{{ route('roles.create') }}" class="text-muted text-decoration-none ms-2">Create Peran</a>
      </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mx-4 mt-4" role="alert">
        <strong>Oops!</strong> Ada beberapa masalah dengan inputan Anda:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-4 mt-4" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden p-5">
      <h3 class="mb-5">Tambah Peran</h3>
      <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="role_name" class="form-label">Nama Peran</label>
            <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Masukkan nama peran" required>
        </div>

        <div class="mb-4">
            <label for="permissions" class="form-label">Tambah Hak Akses</label>
            <select name="permissions[]" id="permissions" class="form-control" multiple="multiple" required>
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn" style="background-color: #19508C; color:white;">Simpan Perubahan</button>
        </div>
    </form>
    </div>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
        $('#permissions').select2({
            placeholder: "Tambah Hak Akses",
            allowClear: true,
            width: '100%'
        });
   });
</script>
@endsection
