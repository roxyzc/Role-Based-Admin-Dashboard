@extends('layout.main')

@section('title', 'Edit Tim')

@section('content')
<div class="d-flex">
    <div class="flex-grow-1 d-flex flex-column">

        <div class="d-flex justify-content-start align-items-center gap-3 ps-3" style="margin-top: 120px;">
            <a href="{{ route('teams.index') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
            <div class="d-flex align-items-center">
                <span class="text-muted">Home &gt;</span> 
                <span class="text-muted ms-2">Beban Kerja &gt;</span>
                <span class="text-muted ms-2">Edit</span>
            </div>
        </div>

        <div class="container mt-4">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 list-unstyled">
                    <li class="small">{{ session('error') }}</li>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('teams.update', $team->id) }}" method="POST">
                        @csrf
                        @method('PUT')
    
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold"> Edit Nama Tim</label>
                            <input type="text" id="name" name="name" class="form-control shadow-sm" 
                                   value="{{ $team->name }}" required 
                                   placeholder="Masukkan nama tim">
                        </div>
    
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary shadow-sm" style="border-radius: 8px; background-color: #19508C;">Simpan perubahan</button>
                            <a href="{{ route('teams.index') }}" class="btn btn-secondary shadow-sm">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection