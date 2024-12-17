@extends('layout.main')

@section('title', 'Beban kerja')

@section('content')
<div class="d-flex">
    <div class="flex-grow-1 d-flex flex-column">
        <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
            <a href="{{ route('teams.index') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
            <div class="d-flex align-items-center">
                <span class="text-muted">Home &gt;</span> 
                <span class="text-muted ms-2">Beban Kerja &gt;</span>
                <span class="text-muted ms-2">Buat Tim</span>
            </div>
        </div>
        
        <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden p-4">
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

            <h3 class="mb-5">Buat Tim</h3>
            <form action="{{ route('teams.store') }}" method="POST">
                @csrf
            <div class="mb-4">
                <div class="form-group mb-4">
                    <label for="task_name" class="form-label"><strong>Nama<span class="text-danger">*</span></strong></label>
                    <input type="text" id="task_name" name="name" class="form-control" placeholder="Masukkan nama tim" required>
                </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary" style="border-radius: 8px; background-color: #19508C;">Buat Tim</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection