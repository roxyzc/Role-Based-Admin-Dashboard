@extends('layout.main')

@section('title', 'Aktivitas')

@section('content')
<div class="d-flex">
    <div class="flex-grow-1 d-flex flex-column">
        <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
            <a href="{{ route('dashboard') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
            <div class="d-flex align-items-center">
                <span class="text-muted">Home &gt;</span> 
                <span class="text-muted ms-2">Aktivitas</span>
            </div>
        </div>
 
        <div class="bg-white rounded-3 shadow mx-4 mt-4 overflow-hidden">
            <div class="p-2 d-flex justify-content-end align-items-center bg-white">
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
                  <th scope="col" class="text-center">Tipe</th>
                  <th scope="col" class="text-center">Aktivitas</th>
                  <th scope="col" class="text-center">Terakhir Diakses</th>
                </tr>
              </thead>
              <tbody>
                   @foreach($logs as $log)
                   <tr>
                       <td class="text-center" style="font-weight: 500;">{{ $log->activity_type }}</td>
                       <td class="text-center" style="font-weight: 500;">{!! $log->description !!}</td>
                       <td class="text-center" style="font-weight: 500;">{{ $log->created_at->translatedFormat('l, d F Y H:i') }}</td>
                   </tr>
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
@endsection