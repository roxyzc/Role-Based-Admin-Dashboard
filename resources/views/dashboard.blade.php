@extends('layout.main')

@section('title', 'Dashboard')

@section('content')

<style>
@media (max-width: 1200px) {
  .container-fluid.p-4 {
    padding: 1.5rem;
  }

  .d-flex.flex-column.flex-md-row {
    flex-direction: column;
    gap: 1.5rem;
  }

  .form-group {
    width: 100%;
  }

  .col-md-4 {
    flex-basis: 100%;
  }

  .card {
    margin-bottom: 1rem;
    width: 100%;
  }

  canvas {
    width: 100% !important;
    height: auto !important;
  }

  .card-body {
    padding: 1.5rem;
  }
}

@media (max-width: 768px) {
  .container-fluid.p-4 {
    padding: 1rem;
  }

  .row.g-4 {
    row-gap: 1.5rem;
  }

  .d-flex.align-items-center.justify-content-center.mb-2 h6 {
    font-size: 18px;
  }

  .d-flex.align-items-center.justify-content-center.mb-2 img {
    width: 25px;
    height: 25px;
  }

  .d-flex.justify-content-between.align-items-center span {
    font-size: 14px;
  }

  .btn.w-100 {
    padding: 0.75rem;
    font-size: 14px;
  }

  canvas {
    width: 100% !important;
    height: auto !important;
  }
}

@media (max-width: 576px) {
  .d-flex.align-items-center.justify-content-center.mb-2 h6 {
    font-size: 14px;
  }

  .d-flex.align-items-center.justify-content-center.mb-2 img {
    width: 20px;
    height: 20px;
  }

  .d-flex.justify-content-between.align-items-center span {
    font-size: 12px;
  }

  .card-body.p-5 {
    padding: 1.5rem;
  }

  .d-flex > .fw-semibold {
    margin-right: 10px;
  }

  .btn.w-100 {
    font-size: 12px;
    padding: 0.5rem;
  }
}
</style>

<div class="flex-grow-1 d-flex flex-column" style="margin-top: 90px;">
    <div class="container-fluid p-4">
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
        
        <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
            <div class="d-flex flex-column flex-md-row gap-4 align-items-start">
                <div class="form-group flex-grow-1">
                    <label for="teamSelect" class="mb-1">Pilih Tim</label>
                    <select class="form-select" name="team_id" id="teamSelect" style="border-radius:10px;" onchange="this.form.submit()">
                        <option value="all">Semua Tim</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ $team->id == $selectedTeamId ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="startDate" class="mb-1">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="startDate" name="start_date" value="{{ $startDate->format('Y-m-d') }}" onchange="this.form.submit()">
                </div>
                <div class="form-group">
                    <label for="endDate" class="mb-1">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="endDate" name="end_date" value="{{ $endDate->format('Y-m-d') }}" onchange="this.form.submit()">
                </div>
            </div>
        </form>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm text-center hover-blue" style="border-radius:20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                        <img src="{{ asset('images/totalprojek.png') }}" alt="Project Image" class="img-fluid me-1" style="width: 30px; height: 30px; object-fit: cover;">
                        <h6 class="card-title mb-0" style="font-size:22px;">Project Selesai</h6>
                    </div>
                        <h2>{{ $totalProjectsCompleted }}</h2>
                        <p style="font-weight: bold; font-size: 15px;">Semua Project Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center hover-blue" style="border-radius:20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                        <img src="{{ asset('images/rataratawaktu.png') }}" alt="Project Image" class="img-fluid me-1" style="width: 30px; height: 30px; object-fit: cover;">
                        <h6 class="card-title mb-0" style="font-size:22px;">Rata Rata Waktu</h6>
                    </div>
                        <h2>{{ $averageCompletionTimeFormatted ?? 'N/A' }}</h2>
                        <p style="font-weight: bold; font-size: 15px;">Lama Penyelesaian Project</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center hover-blue" style="border-radius:20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                        <img src="{{ asset('images/persentase.png') }}" alt="Project Image" class="img-fluid me-1" style="width: 30px; height: 30px; object-fit: cover;">
                        <h6 class="card-title mb-0" style="font-size:22px;">Persentase</h6>
                    </div>
                        <h2>{{ $completionPercentage }}%</h2>
                        <p style="font-weight: bold; font-size: 15px;">Project Selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius:15px;">
                    <div class="card-body">
                        <h6>Total Projek</h6>
                        <h5 class="fw-bold">Statistik</h5>
                        <div>
                            <canvas id="statistikChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::user()->role->hasPermission('package_log_activity'))
          <div class="col mt-5">
              <div class="card shadow-sm" style="border-radius: 20px">
                  <div class="card-body p-5">
                      <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                      <div class="list-group mt-3">
                        @if(Optional($logs)->count() > 0)
                          @foreach($logs as $log)
                          <div class="list-group-item d-flex align-items-center border-0 py-3">
                              <i class="bi bi-check-circle-fill text-success fs-4"></i>
                              <div class="ms-3 w-100">
                                  <div class="d-flex justify-content-between align-items-center">
                                      <span class="fw-semibold">{!! $log->description !!}</span>
                                      <span class="text-muted small">Terakhir Dibuka: {{ $log->created_at->translatedFormat('l, d F Y H:i') }}</span>
                                  </div>
                              </div>
                          </div>
                          @endforeach
                          <div class="text-center mt-3">
                              <a href="{{ route('activity.history') }}" class="btn w-100 text-white" style="background-color: #19508C;">Lihat Semua</a>
                          </div>
                        @else
                          <div class="list-group-item d-flex align-items-center border-0 py-3">
                            <div class="text-center w-100">
                                <i class="bi bi-info-circle text-muted fs-3"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada aktivitas terbaru.</p>
                            </div>
                          </div>
                        @endif
                      </div>
                  </div>               
              </div>
          </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statistikChart').getContext('2d');
    const statistikChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Proyek',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(25, 80, 140, 1)',
                borderColor: 'rgba(25, 80, 140, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah Proyek' }
                }
            }
        }
    });
</script>

@endsection