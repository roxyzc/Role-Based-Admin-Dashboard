<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produktivitas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #2496C8;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h2>LAPORAN PRODUKTIVITAS TIM</h2>
        <p><strong>Tim:</strong> {{ $teams->find($selectedTeam)->name ?? 'N/A'  }}</p>
        <p><strong>Bulan:</strong> {{ $selectedMonth ?? 'Semua Bulan' }}</p>
    </div>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produktivitas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #2496C8;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h2>LAPORAN PRODUKTIVITAS TIM</h2>
        <p><strong>Tim:</strong> {{ $teams->find($selectedTeam)->name ?? 'N/A'  }}</p>
        <p><strong>Bulan:</strong> {{ $selectedMonth ?? 'Semua Bulan' }}</p>
    </div>

    <table>
        <thead>
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
            @foreach($tasks as $task)
                <tr>

                    <td>{{ $task->assignee ? $task->assignee->username : 'Tidak Ada Anggota' }}</td>
                    <td>{{ $task->task_count }}</td>
                    <td>{{ $task->formatted_completion_time }}</td>
                    <td>{{ $task->productivity }}</td>
                    <td>{{ round($task->efficiency) }}%</td>
                    <td>{{ round($task->accuracy) }}%</td>
                    <td>{{ $task->total_tasks }}</td>
                    <td>
                        @php
                            $hours = floor($task->total_work_seconds / 3600); 
                            $minutes = floor(($task->total_work_seconds % 3600) / 60); 
                        @endphp
                        @if($hours > 0)
                            {{ $hours }} jam {{ $minutes }} menit
                        @elseif($hours > 0 && $minutes == 0)
                            {{ $hours }} jam
                        @else
                            {{ $minutes }} menit
                        @endif
                    </td>
                    <td>{{ $task->formatted_idle_time }} menit</td>
                </tr>
            @endforeach
        </tbody>
    </table>



</body>
</html>

