@extends('layout.main')

@section('title', 'Detail Tugas')

@section('content')
<div class="flex-grow-1 d-flex flex-column">
    <div class="d-flex justify-content-start align-items-center gap-3" style="margin-top: 120px;">
        <a href="{{Str::contains(url()->previous(), route('teams.show', '')) 
    ? (url()->previous() == url()->current() ? route('teams.index') : url()->previous()) 
    : route('workload', $id_user) }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
            <span class="text-muted">Home &gt;</span>
            <span class="text-muted ms-2">Beban Kerja &gt;</span>
            <span class="text-muted ms-2">Detail Tugas</span>
        </div>
    </div>

    @if($errors->any())
        <div class="mt-4 alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 list-unstyled">
                @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card shadow-lg border-0 mt-3">
        <div class="card-header bg-white text-center text-primary py-4">
            <h1 class="fw-bold mb-0">{{ $task->task_name }}</h1>
            <p class="mb-0">Deadline: <strong>{{ $task->deadline }}</strong></p>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-lg-7">
                    <h5 class="text-primary fw-bold">Deskripsi Tugas</h5>
                    <p>{{ $task->description }}</p>
                </div>
                <div class="col-lg-5">
                    <h5 class="text-primary fw-bold">Detail</h5>
                    <p><strong>Tim:</strong> {{$name_team}}</p>
                    @if(Auth::user()->role->role_name != 'anggota')
                        <p><strong>User:</strong> {{$name_user}}</p>
                    @endif
                    <p><strong>Prioritas:</strong> {{ ucfirst($task->priority) }}</p>
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge 
                            @if($task->status == 'complete') bg-success 
                            @elseif($task->status == 'pending') bg-warning
                            @elseif($task->status == 'progress') bg-primary 
                            @else bg-secondary @endif">
                            {{ ucfirst($task->status) }}
                        </span>
                    </p>
                    <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" class="mt-2" id="status-form">
                        @csrf
                        <select name="status" class="form-select" id="status-select">
                            <option value="progress" {{ $task->status == 'progress' ? 'selected' : '' }}>Sedang Berlangsung</option>
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Periksa</option>
                            <option value="complete" {{ $task->status == 'complete' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="text-primary fw-bold">File</h5>
                    <div class="border rounded p-3 shadow-sm">
                        <iframe id="file-preview" 
                            src="{{ $task->file ? asset('storage/' . $task->file) : '' }}" 
                            class="w-100" 
                            style="height: 400px; border: none; background-color: {{ $task->file ? 'transparent' : '#D3D3D3' }};">
                        </iframe>
                        <div class="text-center mt-3">
                            @if ($task->file)
                                <a href="{{ asset('storage/' . $task->file) }}" 
                                   class="btn btn-outline-primary" download="{{ basename($task->file) }}">
                                   <i class="bi bi-download"></i> Unduh File
                                </a>
                            @else
                                <div id="file-message" class="file-message alert alert-warning text-center">Belum ada file yang diunggah.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="text-primary fw-bold">Upload File</h5>
                    <form action="{{ route('tasks.uploadFile', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="file" class="form-control" id="file-input" accept=".pdf,.txt,.png,.jpg" required>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                        </div>
                        <small class="text-muted d-block mt-1">Jenis file yang diizinkan: PDF, TXT, JPG, PNG, JPEG. Maksimal 10 MB.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('file-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('file-preview');
        const fileMessage = document.getElementById('file-message');

        if (file) {
            let fileName = file.name;
            let fileExtension = fileName.slice(fileName.lastIndexOf('.') + 1).toLowerCase();

            if(fileExtension == 'png' || fileExtension == 'jpg' || fileExtension == 'jpeg' || fileExtension == 'pdf' || fileExtension == 'txt'){
                const fileURL = URL.createObjectURL(file); 
                preview.src = fileURL; 
                preview.style.backgroundColor = 'transparent'; 
                fileMessage.style.display = 'none'; 
            }else{
                const previousFile = '{{ asset("storage/" . $task->file) }}' || null;

                if (previousFile) {
                    preview.src = previousFile;
                    preview.style.backgroundColor = 'transparent';
                    fileMessage.style.display = 'none'; 
                } else {
                    preview.src = '';
                    preview.style.backgroundColor = '#D3D3D3'; 
                    fileMessage.style.display = 'block';
                }
            }
        } else {
            const previousFile = '{{ asset("storage/" . $task->file) }}' || null;

            if (previousFile) {
                preview.src = previousFile;
                preview.style.backgroundColor = 'transparent';
                fileMessage.style.display = 'none'; 
            } else {
                preview.src = '';
                preview.style.backgroundColor = '#D3D3D3'; 
                fileMessage.style.display = 'block';
            }
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#status-select').on('change', function() {
            let status = $(this).val();
            let taskId = '{{ $task->id }}'; 

            $.ajax({
                url: '/tasks/' + taskId + '/update-status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                },
                success: function(response) {
                    let badgeClass = '';
                    if (response.status === 'complete') {
                        badgeClass = 'bg-success';
                    } else if (response.status === 'progress') {
                        badgeClass = 'bg-primary';
                    } else if (response.status === 'pending') {
                        badgeClass = 'bg-warning';
                    } else {
                        badgeClass = 'bg-secondary';
                    }
                    $('.badge').removeClass().addClass('badge ' + badgeClass).text(response.status.charAt(0).toUpperCase() + response.status.slice(1));
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ' + error);
                }
            });
        });
    });
</script>
@endsection
