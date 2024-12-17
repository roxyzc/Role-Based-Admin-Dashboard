@extends('layout.main')

@section('title', 'Tambah Anggota')
@section('content')
<div class="d-flex">
    <div class="flex-grow-1 d-flex flex-column">
        <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
            <a href="{{ route('teams.index') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
            <div class="d-flex align-items-center">
                <span class="text-muted">Beban Kerja &gt;</span> 
                <span class="text-muted ms-2">Tambah Anggota</span>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden p-4">
            <h3 class="mb-4 text">Tambah Anggota ke Tim</h3>
            <p class="text-muted mb-4">Pilih anggota yang ingin Anda tambahkan ke tim ini.</p>
            <div class="container mt-3">
                <form action="{{ route('teams.addMember', $team->id) }}" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <div class="d-flex flex-column gap-3">
                        <label for="user_id" class="form-label mb-0 fw-bold">Pilih Anggota:</label>
                        <select name="user_id" id="user_id" class="form-control form-select" style="border-radius: 5px;">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" style="border-radius: 8px; background-color: #19508C;">Tambah Anggota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
  
@endsection