@extends('layout.main')

@section('title', 'Beban Kerja')
@section('content')
<div class="flex-grow-1 d-flex flex-column">
    <div class="px-4 d-flex justify-content-start align-items-center gap-3" style="margin-top: 120px;">
        <a href="{{ Auth::user()->role->role_name == 'anggota'? route('dashboard') : (url()->previous() == url()->current() ? route('teams.index') : url()->previous()) }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
        <div class="d-flex align-items-center">
            <span class="text-muted">Home &gt;</span>
            <span class="text-muted ms-2">Beban Kerja</span>
        </div>
    </div>
    
    <div class="mt-4 px-4">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 shadow">
                    <div>
                        <h5 class="text-muted mb-1">Total Tugas</h5>
                        <h3 class="mb-0">{{ $tasks->count() }}</h3>
                    </div>
                    <i class="bi bi-clipboard-check fs-4 text-success"></i>
                </div>
            </div>
    
            <div class="col">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 shadow">
                    <div>
                        <h5 class="text-muted mb-1">Tugas Selesai</h5>
                        <h3 class="mb-0">{{ $completedTasks->count() }}</h3>
                    </div>
                    <i class="bi bi-check-circle fs-4 text-primary"></i>
                </div>
            </div>
    
            <div class="col">
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 shadow">
                    <div>
                        <h5 class="text-muted mb-1">Waktu Idle</h5>
                        <h3 class="mb-0">{{ $idleTime }}</h3>
                    </div>
                    <i class="bi bi-clock fs-4 text-warning"></i>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="fs-5 fw-bold">Ringkasan Tugas</h4>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="text-center p-4 rounded-3 shadow bg-light">
                        <h5>Prioritas Rendah</h5>
                        <p class="fs-4">{{ $taskCounts['Low'] }}</p>
                    </div>
                </div>
                <div class="col">
                    <div class="text-center p-4 rounded-3 shadow bg-light">
                        <h5>Prioritas Sedang</h5>
                        <p class="fs-4">{{ $taskCounts['Medium'] }}</p>
                    </div>
                </div>
                <div class="col">
                    <div class="text-center p-4 rounded-3 shadow bg-light">
                        <h5>Prioritas Tinggi</h5>
                        <p class="fs-4">{{ $taskCounts['High'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="fs-5 fw-bold">Total Beban Kerja</h4>
            <div class="d-flex justify-content-center p-4 rounded-3 bg-light shadow">
                <div class="text-center">
                    <h5>Total Poin</h5>
                    <p class="fs-4">{{ $totalWorkload }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3 shadow mt-4 overflow-hidden">
            <div class="p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-5">Tugas</span>
                    <span class="badge bg-secondary">{{ $totalTasks }}</span>
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
            <div class="table-responsive">
                <table class="table table-bordered mb-0" style="background-color: #F7F6FE">
                    <thead class="table-primary" style="background-color: #CFE4FB">
                        <tr>
                            <th scope="col" class="text-center">Tugas</th>
                            <th scope="col" class="text-center">Prioritas</th>
                            <th scope="col" class="text-center">Waktu Penyelesain</th>
                            <th scope="col" class="text-center">Deadline</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tasks->count() > 0)
                            @foreach ($tasks as $task)
                            <tr>
                                <td class="text-center align-middle">{{ $task->task_name }}</td>
                                <td class="text-center align-middle">{{ $task->priority }}</td>
                                <td class="text-center align-middle">
                                    @if($task->completion_time)
                                        {{ $task->completion_time }}
                                    @else
                                        Belum Selesai
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{ $task->deadline }}</td>
                                <td class="text-center align-middle" style="vertical-align: middle; padding: 4px 6px; font-size: 12px;">
                                    @if($task->status == 'complete')
                                        <span class="badge bg-success" style="font-size: 12px;">Selesai</span>
                                    @elseif($task->status == 'pending')
                                        <span class="badge bg-warning" style="font-size: 12px;">Pending</span>
                                    @else
                                        <span class="badge bg-primary" style="font-size: 12px;">Sedang Berlangsung</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle" style="vertical-align: middle; padding: 4px 6px; font-size: 12px;">
                                    @if(Auth::user()->role->role_name == 'manager')
                                        @if($task->team->user_id == Auth::user()->id)
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-primary" title="Detail" style="display: flex; justify-content: center; align-items: center; height: 21px; font-size: 12px; max-width: 60px; margin: 0 auto; border-radius:6px">
                                                <i class="bi bi-eye" style="margin-right: 5px;"></i> Detail
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak dapat diakses</span>
                                        @endif
                                    @else
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-primary" title="Detail" style="display: flex; justify-content: center; align-items: center; height: 21px; font-size: 12px; max-width: 60px; margin: 0 auto; border-radius:6px">
                                            <i class="bi bi-eye" style="margin-right: 5px;"></i> Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>                            
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center" style="color: red;">Data tidak ditemukan</td>
                            </tr>
                        @endif  
                    </tbody>
                </table>
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
@endsection
