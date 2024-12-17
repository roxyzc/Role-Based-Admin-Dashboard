@extends('layout.main')

@section('title', 'Laporan')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan dan Analitik - Admin/Manajer</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- jsPDF for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- SheetJS for Excel generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
</head>
<body>
<div class="flex-grow-1 d-flex flex-column" style="margin-left: 0px;">
<header class="d-flex justify-content-between align-items-center p-4 shadow" 
style="background-image: url('{{ asset('images/peran.png') }}'); background-size: cover; background-position: center;">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('dashboard') }}" class="btn btn-light fs-6" style="font-weight: bold;">&lt;</a>
    </div>

    <div class="d-flex align-items-center gap-4">
        <a href="{{ route('notifications.index') }}" class="btn">
            <span class="material-icons fs-4" style="color: #055994;">notifications</span>
        </a>

        <a href="{{ route('settings.index') }}">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/'. explode("public/", Auth::user()->profile_picture)[1]) : asset('images/profile.png')}}" alt="User" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
        </a>
    </div>
</header>

<div class="container my-5">
    <!-- Filter by Department or Team -->
    <div class="row mb-4">
        <div class="col-md-6">
            <label for="team" class="form-label">Pilih Tim:</label>
            <select class="form-select" id="team">
                <option selected>Pilih Tim</option>
                <option value="marketing">IT</option>
                <option value="development">Development</option>
                <option value="sales">Sales</option>
                <option value="support">Customer Support</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="bulan" class="form-label">Pilih Bulan:</label>
            <select class="form-select" id="bulan">
                <option selected>Pilih Bulan</option>
                <option value="januari">Januari</option>
                <option value="februari">Februari</option>
                <option value="maret">Agustus</option>
                <!-- Add more months as needed -->
            </select>
        </div>
    </div>

    <!-- Report Header -->
    <div class="report-header text-center mb-4">
        <h2>LAPORAN TIM</h2>
        <p><strong>Tim: IT</strong></p>
        <p><strong>Laporan Bulan:</strong> Agustus 2024</p>
    </div>

    <!-- Laporan Tim/Departemen -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #2496C8; color: white;">
            <h5 class="card-title">Laporan Tim IT</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped text-center" id="reportTable" style="background-color: #F7F6FE">
                <thead style="background-color: #CFE4FB">
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
                    <tr>
                        <td>John Doe</td>
                        <td>25</td>
                        <td>30 jam</td>
                        <td>95%</td>
                        <td>90%</td>
                        <td>85%</td>
                        <td>15 Tugas</td>
                        <td>40 jam</td>
                        <td>4 jam</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>20</td>
                        <td>25 jam</td>
                        <td>90%</td>
                        <td>85%</td>
                        <td>80%</td>
                        <td>10 Tugas</td>
                        <td>35 jam</td>
                        <td>5 jam</td>
                    </tr>
                </tbody>
            </table>

            <!-- Dropdown Unduh Laporan -->
            <div class="mt-3 text-end">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download"></i> Unduh Laporan
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#" id="downloadPDF"><i class="fas fa-file-pdf"></i> PDF</a></li>
                        <li><a class="dropdown-item" href="#" id="downloadExcel"><i class="fas fa-file-excel"></i> Excel</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS & Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS for Export -->
<script>
    document.getElementById('downloadPDF').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Laporan Tim/Departemen", 20, 10);
        doc.autoTable({ html: '#reportTable' });
        doc.save('Laporan_Tim_Departemen.pdf');
    });

    document.getElementById('downloadExcel').addEventListener('click', function() {
        const table = document.getElementById('reportTable');
        const wb = XLSX.utils.table_to_book(table, { sheet: 'Laporan' });
        XLSX.writeFile(wb, 'Laporan_Tim_Departemen.xlsx');
    });
</script>
</body>
</html>
@endsection