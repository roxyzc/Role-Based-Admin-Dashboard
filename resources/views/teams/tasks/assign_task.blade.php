@extends('layout.main')

@section('title', 'Tambah Tugas Pengguna')
@section('content')
<style>
    /* Pagination styling */
    .pagination .page-link {
      color: #055994; /* Light Blue */
      border: none;
      font-weight: 500;
      text-decoration: none !important;
    }

    .pagination .page-link.active {
      background-color: #0275d8; /* Blue for Active Page */
      color: white;
      border-radius: 4px;
      font-weight: 600;
    }

    .pagination .page-link:hover {
      background-color: #f0f0f0; /* Hover Effect */
      color: #055994;
    }

    /* Button link styling */
    .btn-link {
      font-size: 16px;
      text-decoration: none !important;
      color: #6c757d;
      font-weight: 400;
      background: transparent;
      padding: 0;
    }

    .btn-link:hover {
      color: #6c757d;
    }

    /* Icon sizing */
    .btn-link .material-icons {
      font-size: 14px;
      vertical-align: middle;
    }

    /* Pagination link padding */
    .pagination .page-item .page-link {
      padding: 8px 16px;
      margin: 0 4px;
    }

    /* Placeholder color for search input */
    .form-control.text-white::placeholder {
      color: white;
    }

    /* Custom styles for buttons */
    .custom-btn {
    font-size: 12px;
    padding: 5px 5px;
    font-weight: 100;
    border-radius: 8px;
    margin-left: 5px; /* Small gap between buttons */
    transition: all 0.3s ease; /* Menambahkan transisi untuk efek hover */
    }

    .custom-btn.btn-sm {
        font-size: 16px; /* Mengatur ukuran font tombol */
        padding: 8px 16px; /* Mengatur padding tombol untuk membuatnya lebih kecil */
        margin-left: 5px; /* Mengatur jarak antar tombol */
        border-radius: 8px; /* Menjaga border radius tetap */
    }

    .btn-success.custom-btn {
    background-color: #28a745;
    color: white;
    }

    .btn-danger.custom-btn {
    background-color: #dc3545;
    color: white;
    }

    /* Hover effect for buttons */
    .custom-btn:hover {
    opacity: 0.8;
    cursor: pointer;
    }

    .button-group {
    display: flex;
    justify-content: flex-end;
    }

</style>
<div class="flex-grow-1 d-flex flex-column">
    <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
        <a href="{{ route('teams.show', request()->segment(2)) }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
            <span class="text-muted">Home &gt;</span>
            <span class="text-muted">Beban kerja &gt;</span> 
            <span class="text-muted ms-2">Tambah Tugas</span>
        </div>
    </div>

    @if($errors->any())
        <div class="px-4 mt-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>  
        </div>
    @endif


    <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden p-4">
    <h3 class="mb-5">Berikan tugas untuk tim: {{ ucwords($team->name) }}</h3>

    <form action="{{ route('teams.tasks.store', $team->id) }}" method="POST">
    @csrf
    <div class="mb-4">
        <div class="form-group mb-4">
            <label for="task_name" class="form-label"><strong>Nama Tugas <span class="text-danger">*</span></strong></label>
            <input type="text" id="task_name" name="task_name" class="form-control" placeholder="Masukkan nama tugas" value="{{ old('task_name') }}" required>
        </div>
        <div class="form-group mb-4">
            <label for="description" class="form-label"><strong>Deskripsi Tugas <span class="text-danger">*</span></strong></label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Deskripsi tugas" required>{{ old('description') }}</textarea>
        </div>
        <div class="form-group mb-4">
            <label for="id_user" class="form-label"><strong>Pilih Anggota Tim <span class="text-danger">*</span></strong></label>
            <select id="id_user" name="id_user" class="form-select" required>
                <option value="">Pilih Anggota</option>
                @foreach($team->members as $member)
                    <option value="{{ $member->id }}" {{ old('id_user') == $member->id ? 'selected' : '' }}>{{ $member->username }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-4">
            <label for="priority" class="form-label"><strong>Prioritas <span class="text-danger">*</span></strong></label>
            <select id="priority" name="priority" class="form-select" required>
                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Rendah</option>
                <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Sedang</option>
                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>Tinggi</option>
            </select>
        </div>
        <div class="form-group mb-4">
            <label for="deadline" class="form-label"><strong>Batas Waktu <span class="text-danger">*</span></strong></label>
            <input type="datetime-local" id="deadline" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
        </div>

        <div class="button-group mt-4">
            <button type="submit" class="btn btn-success custom-btn btn-sm" id="submitButton">Simpan Tugas</button>
            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-danger custom-btn btn-sm" id="cancelButton">Batal</a>                    
        </div>
    </form>
</div>

@endsection
