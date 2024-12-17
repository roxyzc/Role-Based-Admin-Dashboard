@extends('layout.main')

@section('title', 'Laporan')

@section('content')

<style>
    @media (max-width: 767px) {
        .card-header {
            padding-left: 15px; 
            padding-right: 15px; 
        }

        .card-body {
            padding: 15px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .form-select {
            width: 100%;
        }

        .report-header h2 {
            font-size: 1.5rem;
        }

        .report-header p {
            font-size: 1rem;
        }
    }

    @media (max-width: 991px) {
        .report-header h2 {
            font-size: 1.75rem;
        }

        .report-header p {
            font-size: 1.1rem;
        }
    }

    .card-header {
        padding-left: 15px; 
        padding-right: 15px; 
    }
</style>

<div class="flex-grow-1 d-flex flex-column" style="margin-top: 90px;">
    <div class="container-fluid p-4">
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="d-flex flex-column flex-md-row  align-items-start">
                <div class="form-group col-md-6 col-12 p-4">
                    <label for="team" class="form-label">Pilih Tim:</label>
                    <select class="form-select" id="team" name="team_id" onchange="this.form.submit()">
                        <option value="">Pilih Tim</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ $selectedTeam == $team->id ? 'selected' : '' }}>{{ ucwords($team->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6 col-12 p-4">
                    <label for="bulan" class="form-label">Pilih Bulan:</label>
                    <select class="form-select" id="bulan" name="month" onchange="this.form.submit()">
                        <option value="">Pilih Bulan</option>
                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                            <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="report-header text-center mb-4">
    <h2>LAPORAN TIM</h2>
    <p><strong>Tim: {{ optional($teams->find($selectedTeam))->name ? ucwords(optional($teams->find($selectedTeam))->name) : 'N/A' }}</strong></p>
    <p><strong>Laporan Bulan:</strong> {{ $selectedMonth ?? 'Semua Bulan' }}</p>
</div>

<div class="card mb-4">
    <div class="card-header" style="background-color: #19508C; color: white;">
        <h5 class="card-title">Laporan Tim</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 text-center" id="reportTable" style="background-color: #F7F6FE">
                <thead class="table-primary" style="background-color: #CFE4FB">
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Tugas Diselesaikan</th>
                        <th>Waktu Penyelesaian</th>
                        <th>Produktivitas</th>
                        <th>Efisiensi</th>
                        <th>Akurasi</th>
                        <th>Tugas Dikerjakan</th>
                        <th>Waktu Kerja</th>
                        <th>Waktu Idle</th>
                    </tr>
                </thead>
                <tbody>
                @if($tasks->count() > 0)
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->assignee ? ucwords($task->assignee->username) : 'Tidak Ada Anggota' }}</td>
                            <td>{{ $task->task_count }}</td>
                            <td>{{ $task->formatted_completion_time }}</td>
                            <td>{{ $task->productivity }}</td>
                            <td>{{ round($task->efficiency) }}%</td> 
                            <td>{{ round($task->accuracy) }}%</td> 
                            <td>{{ $task->total_tasks }}</td>
                            <td>
                                @php
                                    $hours = floor($task->total_work_seconds / 3600); // Mengonversi detik ke jam
                                    $minutes = floor(($task->total_work_seconds % 3600) / 60); // Sisa detik ke menit
                                @endphp
                                {{ $hours }} jam {{ $minutes }} menit
                            </td>
                            <td>{{ $task->formatted_idle_time }}</td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="9">
                        <div class="alert alert-danger text-center mt-2">
                            <strong>Tidak ada data</strong>
                        </div>
                    </td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>

        <div class="mt-3 text-end">
            <a href="{{ route('reports.export.pdf', ['team_id' => $selectedTeam, 'month' => $selectedMonth]) }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export to PDF</a>
            <a href="{{ route('reports.export.csv', ['team_id' => $selectedTeam, 'month' => $selectedMonth]) }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export to Excel</a>
        </div>
    </div>
</div>

@endsection