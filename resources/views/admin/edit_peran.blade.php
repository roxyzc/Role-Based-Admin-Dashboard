@extends('layout.main')

@section('title', 'Edit Peran')

@section('content')
<style>
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
  <div class="flex-grow-1 d-flex flex-column">
      <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
        <a href="{{ url()->previous() }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
            <span class="text-muted">Home &gt;</span> 
            <span class="text-muted ms-2">Management Peran &gt;</span>
            <span class="text-muted ms-2">Edit Peran</span>
        </div>
      </div>

      <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden p-4">
        <h3 class="mb-5">Edit Peran</h3>
        <form action="{{ route('admin.management_peran.update_user_role', ['role' => $role->id, 'user' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="username" class="form-label mb-2">Username</label>
                <input type="text" name="username" id="username" class="form-control" style="max-width: 500px; border-radius: 5px;" disabled value="{{ $user->username }}">
            </div>
            
            <div class="mb-2">
                <label for="email" class="form-label mb-2">Email</label>
                <input type="text" name="email" id="email" class="form-control" style="max-width: 500px; border-radius: 5px;" disabled value="{{ $user->email }}">
            </div>
            
            <div class="mb-2">
                <label for="peran" class="form-label mb-2">Pilih Role:</label>
                <select name="role_id" id="peran" class="form-select" style="max-width: 500px; border-radius: 5px;">
                    @foreach($roles as $availableRole)
                        <option value="{{ $availableRole->id }}" {{ $user->role_id == $availableRole->id ? 'selected' : '' }}>
                            {{ $availableRole->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary" style="border-radius: 5px;">Update Peran</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection