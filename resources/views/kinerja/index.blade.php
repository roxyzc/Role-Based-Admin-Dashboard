@extends('layout.main')

@section('title', 'Kinerja')

@section('content')
<style>
    .card {
        background-color: white;
    }

    .hover-blue:hover {
        background-color: #1098F7; 
        color: white;
    }

    .hover-blue:hover h6,
    .hover-blue:hover p,
    .hover-blue:hover h2 {
        color: white;
    }

    .card-body .center-content {
        text-align: center;
        margin-top: 8px;
    }

    .center-content h2 {
        margin: 0;
        font-size: 32px;
    }

    .center-content p {
        margin: 0;
        font-size: 14px;
        color: #6c757d;
    }

    .chart-container {
        display: flex;
        justify-content: center;  /* Pastikan elemen berada di tengah secara horizontal */
        align-items: center;      /* Pastikan elemen berada di tengah secara vertikal */
        gap: 50px;
        margin-top: 20px;
    }

    .chart-title {
        text-align: center;
        font-weight: bold;
        margin-top: 10px;
    }

    .legend {
        display: flex;
        justify-content: flex-end;
        margin-right: 20px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-right: 15px;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        margin-right: 5px;
    }

    .legend-text {
        font-size: 14px;
    }

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
    width: 80% !important;  
    height: auto !important; 
  }

  .card-body {
    padding: 1.5rem;
  }
}

@media (max-width: 768px) {
    .chart-container {
        flex-direction: column;
        gap: 20px;
        justify-content: center;  
        align-items: center;     
    }

    .container-fluid.p-4 {
        padding-left: 15px;
        padding-right: 15px;
    }

    .row.g-4 .col-md-4 {
        flex: 0 0 100%;
    }

    .legend {
        flex-direction: column;
        justify-content: center;
        margin-right: 0;
        margin-top: 10px;
    }

    .legend-item {
        margin-right: 0;
        margin-bottom: 10px;
    }

    .center-content h2 {
        font-size: 28px;
    }

    .center-content p {
        font-size: 12px;
    }

    .card-body {
        padding: 15px;
    }
    
    .col-md-6 {
        flex: 0 0 100%;
    }

    .card-title {
        font-size: 18px;
    }

    canvas {
        width: 70% !important; 
        margin: 0 auto;
    }
}

@media (max-width: 480px) {
    .card-body h2 {
        font-size: 24px;
    }

    .card-body p {
        font-size: 13px;
    }

    .chart-title {
        font-size: 16px;
    }

    .legend-text {
        font-size: 12px;
    }

    canvas {
        width: 90% !important; 
        margin: 0 auto; 
    }
}

</style>

<div class="flex-grow-1 d-flex flex-column" style="margin-left: 0px;">

<div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
    <a href="{{ route('dashboard') }}" class="btn fs-6 btn-back" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
    <div class="d-flex align-items-center">
        <span class="text-muted">Home &gt;</span>
        <div class="text-muted ms-2">Kinerja</div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
<div class="container-fluid p-4">
<form action="{{ route('kinerja') }}" method="GET">
    <div class="mb-4">
        <label for="teamSelect" class="form-label">Pilih Tim</label>
        <select id="teamSelect" class="form-select" name="team_id" onchange="this.form.submit()">
            <option value="all">Semua Tim</option>
            @foreach($teams as $team)
                <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>
                    {{ $team->name }}
                </option>
            @endforeach
        </select>
    </div>
</form>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm text-center" style="border-radius:20px;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center mb-2">
                <img src="{{ asset('images/totalprojek.png') }}" alt="Project Image" class="img-fluid me-1" style="width: 30px; height: 30px; object-fit: cover;">
                <h6 class="card-title mb-0" style="font-size:22px;">Project Selesai</h6>
            </div>
                <h2>{{ $completedTasks }}</h2>
                <p style="font-weight: bold; font-size: 15px;">Semua Project Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm text-center" style="border-radius:20px;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center mb-2">
                <img src="{{ asset('images/rataratawaktu.png') }}" alt="Project Image" class="img-fluid me-1" style="width: 30px; height: 30px; object-fit: cover;">
                <h6 class="card-title mb-0" style="font-size:22px;">Rata Rata Waktu</h6>
            </div>
                <h2>{{ $averageCompletionTime ?? 'N/A' }}</h2>
                <p style="font-weight: bold; font-size: 15px;">Lama Penyelesaian Project</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm text-center" style="border-radius:20px;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center mb-2">
                <img src="{{ asset('images/persentase.png') }}" alt="Project Image" class="img-fluid me-1" style="width: 30px; height: 30px; object-fit: cover;">
                <h6 class="card-title mb-0" style="font-size:22px;">Persentase</h6>
            </div>
                <h2>{{ $presentase }}%</h2>
                <p style="font-weight: bold; font-size: 15px;">Project Selesai</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
<div class="col-md-12">
<div class="card shadow-sm" style="border-radius:15px;">
    <div class="card-body">
    <h6>Kinerja</h6>
    <h5 class="fw-bold">Grafik Kinerja</h5>
    <div class="legend">
        <div class="legend-item">
        <div class="legend-color" style="background-color: #FF4D4D;"></div>
        <div class="legend-text">Project Berjalan/Terlambat</div>
        </div>
        <div class="legend-item">
        <div class="legend-color" style="background-color: #C7FFDE;"></div>
        <div class="legend-text">Project Selesai</div>
        </div>
    </div>

    <div class="chart-container">
        @if (Auth::user()->role->role_name == 'anggota')
            <div>
            <canvas id="individuChart"></canvas>
            <div class="chart-title">Individu</div>
            </div>
        @endif

        <div>
        <canvas id="teamChart"></canvas>
        <div class="chart-title">Team</div>
        </div>
    </div>
    </div>
</div>
            
<div class="col-md-12 mt-5">
  <div class="card shadow-sm" style="border-radius:15px; ">
      <div class="card-body">
        <h5 class="fw-bold">KPI</h5>
        <h6>Tabel KPI</h6>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card shadow-sm">
              <div class="card-body text-center">
                <h6>Produktivitas</h6>
                <h2>{{ $productivity }}</h2>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card shadow-sm">
              <div class="card-body text-center">
                <h6>Efisiensi</h6>
                <h2>{{ $efficiency }}%</h2>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card shadow-sm">
              <div class="card-body text-center">
                <h6>Akurasi</h6>
                <h2>{{ $accuracy }}%</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    const individuData = {
        datasets: [{
        data: [{{ $completionRate }}, {{ 100 - $completionRate }}],
        backgroundColor: ['#C7FFDE', '#FF4D4D'],
        hoverOffset: 4
        }]
    };

    const teamData = {
        datasets: [{
        data: [{{ $completionRateTeam }}, {{ 100 - $completionRateTeam }}],
        backgroundColor: ['#C7FFDE', '#FF4D4D'],
        hoverOffset: 4
        }]
    };

    const config = {
        type: 'pie',
        options: {
        plugins: {
            tooltip: {
            callbacks: {
                label: function (context) {
                console.log(context.label);
                const label = context.label || '';
                const value = context.raw || 0;
                return `${label}: ${value}%`;
                }
            }
            }
        }
        }
    };
    
    new Chart(document.getElementById('individuChart'), {
        ...config,
        data: individuData
    });

    new Chart(document.getElementById('teamChart'), {
        ...config,
        data: teamData
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection