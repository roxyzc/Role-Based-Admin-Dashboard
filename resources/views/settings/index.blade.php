@extends('layout.main')

@section('title', 'Pengaturan')

@section('content')

<style>
    .form-label {
        font-weight: bold;
    }
</style>

<div class="flex-grow-1 d-flex flex-column">
    <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
        <a href="{{ route('dashboard') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
            <span class="text-muted">Home &gt;</span> 
            <span class="text-muted ms-2">Pengaturan</span>
        </div>
    </div>

    <div class="text-left mb-4 mt-5 px-4">
        <ul class="nav nav-pills border-bottom" style="display: flex; gap: 5px;">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('settings.index') }}" style="background-color:#19508C;">Pengaturan Akun</a>
            </li>
            @if(Auth::user()->role->hasPermission('package_notification'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('notifications.index') }}" style="background-color: white; color: #19508C; box-shadow: inset 0 0 0 2px #19508C;  ">Notifikasi</a>
            </li>
            @endif
        </ul>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
        <strong>Oops!</strong> Ada beberapa masalah dengan inputan Anda:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="text-left mb-5 ms-3 px-4">
            <h5>Foto Profil Anda</h5>
            <div class="d-flex justify-content-start align-items-center gap-4 mt-3">
            <img id="profileImage" src="{{ $user->profile_picture ? asset('storage/'. explode("public/", $user->profile_picture)[1]) : asset('images/profile.png') }}" alt="Profile Picture" class="rounded-circle"  style="width: 200px; height: 200px; object-fit: cover;">
            <div>
                <label for="profile_picture" class="btn text-white" style="background-color:#19508C">Ganti Profile</label>
                <input type="file" class="form-control d-none" id="profile_picture" name="profile_picture">
                <a href="{{ route('settings.deleteProfilePicture') }}" class="btn btn-outline-danger">Hapus Profil</a>
            </div>
            </div>
        </div>

        <div class="container px-4">
            <div class="row mb-3 text-left ">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">Nama Depan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', ucwords($user->first_name) ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Nama Belakang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', ucwords($user->last_name) ?? '') }}" required>
                </div>
            </div>
            <div class="row text-left mb-4">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                </div>
            </div>
            <button type="submit" class="btn text-white" style="background-color:#19508C">Update Profile</button>
        </div>
    </form>

    <hr>
    <form action="{{ route('settings.updatePassword') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="container px-4">
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>
            <button type="submit" class="btn text-white" style="background-color:#19508C">Update Password</button>
        </div>
    </form>
</div>
<script>
    const profilePictureInput = document.getElementById('profile_picture');
    const profileImage = document.getElementById('profileImage');
    const originalProfileImageSrc = "{{ $user->profile_picture ? asset('storage/'. explode('public/', $user->profile_picture)[1]) : asset('images/profile.png') }}";

    profilePictureInput.addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            let fileName = file.name;

            let fileExtension = fileName.slice(fileName.lastIndexOf('.') + 1).toLowerCase();

            if (fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg') {
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }else {
                profileImage.src = originalProfileImageSrc;
            }

        } else {
            profileImage.src = originalProfileImageSrc;
        }
    });

    profilePictureInput.addEventListener('click', function() {
        if (!profilePictureInput.files.length) {
            profileImage.src = originalProfileImageSrc;
        }
    });
</script>
@endsection
