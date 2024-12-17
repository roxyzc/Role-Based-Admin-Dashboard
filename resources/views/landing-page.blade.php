<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking.ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 80px;
            width: 100%;
            overflow-x: hidden;
        }

        .nav-link {
            color: #19508C;
            transition: color 0.3s ease;
        }

        .navbar .nav-link {
            color: #000000;
            transition: color 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: #19508C;
        }

        .sticky-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%; 
            z-index: 9999; 
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }

        .btn-outline-secondary {
            border-color: #343a40;
            color: #343a40;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            color: #19508C;
            border-color: #19508C;
        }

        .btn-secondary {
            background-color: #343a40;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #19508C;
            border-color: #19508C;
        }

        .navbar-brand img {
            width: 150px;
            margin-left: 80px;
        }

        .hero-section {
            padding: 100px 0;
            width: 100%;
            margin-top: 60px;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #19508C;
            margin-top: -70px;
            line-height: 1.3;
        }

        .hero-text p {
            color: #6c757d;
            margin-bottom: 100px;
            margin-top: 15px;
            font-size: 1.3rem;
        }

        .btn-dark {
            background-color: #19508C;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-dark:hover {
            background-color: #19508C;
        }

        .btn-outline-dark {
            background-color: transparent;
            color: #19508C;
            border: 1px solid #19508C;
            transition: background-color 0.3s ease, border 0.3s ease;
        }

        .btn-outline-dark:hover {
            background-color: #19508C;
            color: white;
            border: 1px solid #19508C;
        }

        .grey-box {
            background-size: cover;
            background-position: center;
            height: 520px;
            
        }

        .info-section {
            padding: 50px 0;
            background-color: #E6F4FE;
        }

        .info-text {
            max-width: 600px;
        }

        .info-text h2 {
            font-size: 2rem;
            color: #333333;
            
        }

        .info-text p {
            color: #6c757d;
            text-align: justify;
        }

        .fitur-section h2 {
            font-size: 2rem;
            color: #333333;
            margin-bottom: 20px;
        }

        .card {
            width: 100%;
            max-width: 300px;
            height: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: #fff;
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 15px;
            text-align: center;
            margin: 10px;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-icon img {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
            line-height: 20px;
        }


        @media (max-width: 991px) {
            .navbar-brand img {
                width: 120px;
                margin-left: 10px;
            }
            .navbar .nav-link {
                font-size: 14px;
                margin-left: 10px;
            }
            .hero-text h1 {
                font-size: 2rem;
                margin-top:20px;
            }

            .hero-text p {
                font-size: 1.1rem;
                
            }

            .grey-box {
                height: 300px;
            }
        }

        @media (max-width: 768px) {
            .navbar .nav-link {
                font-size: 14px;
                margin-left: 10px;
            }

            .navbar-brand img {
                width: 100px;
                margin-left: 10px;
            }

            .hero-section {
                padding: 50px 0;
            }

            .hero-text h1 {
                font-size: 1rem;
                margin-top:60px;
                margin-left:10px;
                width:334px;
                height:48px;
                weight:600px;
            }

            .hero-text p {
                font-size: 0.8rem;
                margin-left:10px;
            }

            .btn-dark, .btn-outline-dark, .btn-secondary {
                padding: 8px 15px;
                font-size: 14px;
            }

            .grey-box {
                width:341px;
                height: 316px;
                margin: auto; 
                display: flex;
                justify-content: center; 
                align-items: center; 
            }

        }

        @media (min-width: 992px) {
            .fitur-section .d-flex {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 20px;
            }

            .card {
                width: 22%;
                height: 220px;
            }
        }

        @media (max-width: 991px) {
            .fitur-section .d-flex {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 15px;
            }

            .card {
                width: 45%;
                height: 220px;
            }
        }

        @media (max-width: 767px) {
            .fitur-section .d-flex {
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
                height: 220px;
            }

            .card-title {
                font-size: 1.1rem;
            }

            .card-text {
                font-size: 0.95rem;
            }
        }

        .pricing-section {
            background-color: #E6F4FE;
            padding: 50px 0;
        }

        .pricing-card {
            border-radius: 15px;
            height: 433px;
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .pricing-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .pricing-card .card-title {
            color: #1E1E1E;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .card-price {
            font-size: 2rem;
            font-weight: 800;
            color: #1E1E1E;
        }

        .pricing-section button {
            font-size: 1rem;
            font-weight: 300;
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            margin-top: auto;
            background-color: #19508C;
            border: 1px solid #19508C;
            color: white;
            text-align: center;
            transition: background-color 0.3s;
            width: 246px;
            flex-shrink: 0; 
            align-self: center; 
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 1);
        }

        .btn-toggle.active {
            background-color: #19508C;
            color: white;
        }

        .featured-card {
            background-color: #19508C;
            color: white;
        }

        .pricing-card ul {
            list-style-type: disc;
            padding-left: 10px;
            margin-bottom: 1rem;
            text-align: left;
        }

        .pricing-card li {
            margin-bottom: 0.5rem;
        }

        .pricing-section button:hover {
            background-color:#174171;
            color: white;
        }

        .custom-ul {
            color: #757575;
            align-self: center;
        }

        .pricing-section {
            margin: 50px auto;
        }

        .pricing-card {
            padding: 20px;
            border-radius: 10px;
        }

        #pricingCards .col-md-3 {
            display: flex;
            justify-content: center;
        }
        
        @media (max-width: 768px) {
            .pricing-card {
                max-width: 100%;
                height: auto;
            }

            .pricing-section {
                padding: 30px 0;
            }
        }

        .faq-section {
            padding: 100px 0;
        }

        .faq-header, .faq-header-text {
            font-weight: 400;
            font-size: 2rem;
            text-align: center;
            color: #333333;
        }

        .faq-header-text {
            font-weight: 550;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8f9fa;
            color: #212529;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .accordion-item {
            max-width: 1000px;
            margin: 0 auto;
        }

        .accordion-collapse {
            animation: slideDown 0.5s ease forwards;
        }

        .accordion-collapse.collapsing {
            animation: slideUp 0.5s ease forwards;
        }

        .accordion-button {
            font-size: 18px; /
        }

        .accordion-body {
            font-size: 16px; 
        }

        .faq-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #19508C;
        }

        @keyframes slideDown {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

        @keyframes slideUp {
            from { transform: scaleY(1); }
            to { transform: scaleY(0); }
        }

        .contact-form-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #19508C;
        }

        .contact-form-section {
            padding: 50px 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .footer {
            background-color: #ffffff;
            border-top: 1px solid #eaeaea;
            padding: 20px 0;
            margin-top: 100px;
        }

        .container {
            width: 100%;
            max-width: none;
            margin: 0 auto;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .logo {
            width: 150px;
            margin-right: 20px;
        }

        .logo-text {
            font-size: 16px;
            font-weight: bold;
            color: #0056b3;
        }

        .footer-links {
            display: flex;
            flex: 3;
            gap: 50px;
        }

        .footer-column {
            flex: 1;
        }

        .footer-column h5 {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column ul li {
            margin-bottom: 8px;
        }

        .footer-column ul li a {
            text-decoration: none;
            font-size: 16px;
            color: #555;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: #19508C;
        }

        .social-icons {
            display: flex;
            gap: 10px;
        }

        .social-icons a {
            text-decoration: none;
            font-size: 18px;
            color: #000;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color:#19508C;
        }

        @media (min-width: 992px) {
            .footer-content {
                flex-direction: row;
                justify-content: space-between;
            }

            .logo-section {
                margin-left: 70px;
            }

            .footer-links {
                display: flex;
                flex: 3;
                gap: 50px;
            }
        }

        @media (max-width: 991px) {
            .footer-content {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .logo-section {
                margin-left: 0;
                text-align: left;
                flex: 1;
            }

            .footer-links {
                display: flex;
                flex: 3;
                justify-content: space-between;
                gap: 30px;
            }

            .footer-column h5 {
                font-size: 18px;
            }

            .footer-column ul li a {
                font-size: 14px;
            }

            .social-icons {
                justify-content: center;
                gap: 12px;
            }

            .social-icons a {
                font-size: 16px;
            }
        }

        @media (max-width: 767px) {
            .footer-content {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .logo-section {
                margin-left: 0;
                text-align: left;
                flex: 1;
            }

            .footer-links {
                display: flex;
                flex: 3;
                justify-content: space-between;
                gap: 20px;
            }

            .footer-column h5 {
                font-size: 16px;
            }

            .footer-column ul li a {
                font-size: 14px;
            }

            .social-icons {
                justify-content: center;
                gap: 10px;
            }

            .social-icons a {
                font-size: 14px;
            }
        }

        @media (max-width: 992px) {
            #pricingCards .col-md-3 {
                flex: 0 0 48%; 
                max-width: 48%;
                margin: 1%;
            }
        }

        @media (max-width: 768px) {
            #pricingCards .col-md-3 {
                flex: 0 0 100%; 
                max-width: 100%;
            }

            .pricing-card {
                margin-bottom: 20px;
            }

            .card-price {
                font-size: 1.8rem;
            }

            .card-title {
                font-size: 1.4rem; 
            }
        }

        @media (max-width: 576px) {
            .pricing-section h2 {
                font-size: 1.5rem;
            }

            .pricing-card {
                padding: 15px;
            }

            .card-price {
                font-size: 1.5rem;
            }
        }

        </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 sticky-navbar">
    <div class="container">
        <a class="navbar-brand" href="#beranda">
            <img src="{{ asset('images/tracking.id.png') }}" alt="Tracking.ID Logo" class="img-fluid">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-scroll" href="#beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-scroll" href="#fitur">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-scroll" href="#harga">Harga/Paket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-scroll" href="#faq">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://trackingidn.wordpress.com/">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bantuan') }}">Hubungi Kami</a>
                </li>
            </ul>
            @if(Auth::check() == false)
            <div class="d-flex ms-3">
                <a href="{{ route('login') }}" class="btn me-2" style="color: #19508C; border: 1px solid #19508C; background-color: transparent; text-decoration: none;">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="background-color:#19508C">Daftar</a>
            </div>
            @endif
        </div>
    </div>
</nav>

<section id="beranda" class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 order-md-2">
                <div class="grey-box ms-md-5 me-md-5" style="background-image: url('{{ asset('images/landing-page.png')}}');"></div>
            </div>
            <div class="col-md-6 order-md-1">
                <div class="hero-text ms-md-5">
                    <h1>Optimalkan Pengelolaan Akses<br>dan Kinerja Anda</h1>
                    <p>Manajemen hak akses yang aman dan monitoring<br>kinerja yang terintegrasi untuk efisiensi kerja lebih<br>baik.</p>
                    <a href="{{ route('register') }}" class="btn btn-dark me-2">Daftar Sekarang</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark">Mulai Uji Coba Gratis</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="info-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 order-md-1">
                <div class="grey-box ms-md-5" style="background-image: url('{{ asset('images/landing-page-2.png')}}');"></div>
            </div>
            <div class="col-md-6 order-md-2">
                <div class="info-text ms-md-5">
                    <h2>Mengatasi Tantangan dalam Mengelola Akses dan Kinerja</h2>
                    <p>Mengelola akses dan kinerja dalam sebuah organisasi seringkali menjadi tantangan besar bagi tim IT.
                        Platform RBAC kami hadir untuk mempermudah pengelolaan tersebut dengan solusi yang efisien dan aman.
                        Dengan sistem kontrol akses berbasis peran yang terstruktur, Anda dapat mengurangi risiko kesalahan manusia,
                        memastikan keamanan data, dan memantau performa karyawan dengan lebih efektif. Semua proses menjadi lebih transparan,
                        terpusat, dan mudah dikelola—menghemat waktu serta biaya perusahaan. Platform ini memberikan kontrol penuh kepada Anda,
                        sambil memudahkan kolaborasi tim IT dan memastikan bahwa akses selalu berada di tangan yang tepat.
                        Tingkatkan produktivitas dan fokuskan energi pada pengembangan, bukan pada manajemen akses yang rumit.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fitur" class="fitur-section my-5">
    <div class="container">
        <h2 class="text-center mb-4">Tracking.ID mempermudah interaksi dengan pelanggan</h2>
        <div class="d-flex justify-content-center gap-3">
            <div class="card">
                <div class="card-body text-start">
                    <h5 class="card-title">Manajemen Akses</h5>
                    <p class="card-text">Mengelola peran dan hak akses dengan mudah.</p>
                    <div class="card-icon d-flex justify-content-center">
                        <img src="{{ asset('images/manajemenakses.png') }}" alt="Manajemen Akses" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-start">
                    <h5 class="card-title">Monitoring Aktivitas</h5>
                    <p class="card-text">Melihat dan melacak aktivitas pengguna secara real-time.</p>
                    <div class="card-icon d-flex justify-content-center">
                        <img src="{{ asset('images/monitoringaktivitas.png') }}" alt="Monitoring Aktivitas" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-start">
                    <h5 class="card-title">Dashboard Kinerja</h5>
                    <p class="card-text">Melihat performa dan efisiensi tim.</p>
                    <div class="card-icon d-flex justify-content-center">
                        <img src="{{ asset('images/dashboardkinerja.png') }}" alt="Dashboard Kinerja" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-start">
                    <h5 class="card-title">Reporting</h5>
                    <p class="card-text">Menyediakan laporan kinerja yang dapat diunduh.</p>
                    <div class="card-icon d-flex justify-content-center">
                        <img src="{{ asset('images/report.png') }}" alt="Report" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
        <a href="{{ route('register') }}"class="btn" style="background-color:#19508C; color:white;">Get Started</a>
        </div>
    </div>
</section>

<section id="harga" class="pricing-section my-5">
    <div class="container text-center">
        <h2 class="mb-4" style="font-weight:700"> PAKET HARGA</h2>
        <div class="row justify-content-center" id="pricingCards">
            <div class="col-12 col-md-3 mb-4">
                <div class="card pricing-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Gratis</h5>
                        <h2 class="card-price">Rp0<span class="fs-6">/Bulan</span></h2>
                        <hr>
                        <ul class="list-unstyled mb-4 custom-ul">
                            <li><span class="bullet-point"></span> 1 Tim, maksimal 10 anggota</li>
                            <li><span class="bullet-point"></span> Log aktivitas tersedia</li>
                            <li><span class="bullet-point"></span> Tidak dapat unduh laporan <br></br></li>
                        </ul>
                        <a href="https://wa.me/6282297634460?text=Halo,%20saya%20ingin%20mendaftar%20Paket%20Per%20Tahun">
                            <button class="btn btn-primary btn-block">Berlangganan</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-4 monthly-card">
                <div class="card pricing-card featured-card shadow-lg">
                    <div class="card-body">
                    <h5 class="card-title text-white">Per Bulan</h5>
                        <h2 class="card-price text-white">Rp135.000<span class="fs-6">/Bulan</span></h2>
                        <hr class="bg-light">
                        <ul class="list-unstyled text-white mb-4 custom ul">
                            <li><span class="bullet-point"></span> Tim dan anggota tanpa batas</li>
                            <li><span class="bullet-point"></span> Log aktivitas lengkap</li>
                            <li><span class="bullet-point"></span> Dapat unduh laporan</li>
                            <li><span class="bullet-point"></span> Layanan konsultasi</li>
                        </ul>
                        <a href="https://wa.me/6282297634460?text=Halo,%20saya%20ingin%20mendaftar%20Paket%20Per%20Tahun">
                            <button class="btn btn-primary btn-block" style="background-color:#ffffff; color:#19508C">Berlangganan</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-4 monthly-card">
                <div class="card pricing-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Per Tahun</h5>
                        <h2 class="card-price">Rp1.458.000<span class="fs-6">/Tahun</span></h2>
                        <hr>
                        <ul class="list-unstyled mb-4 custom-ul">
                            <li><span class="bullet-point"></span> Tim dan anggota tanpa batas</li>
                            <li><span class="bullet-point"></span> Log aktivitas lengkap</li>
                            <li><span class="bullet-point"></span> Dapat unduh laporan</li>
                            <li><span class="bullet-point"></span> Layanan konsultasi</li>
                        </ul>
                        <a href="https://wa.me/6282297634460?text=Halo,%20saya%20ingin%20mendaftar%20Paket%20Per%20Tahun">
                            <button class="btn btn-primary btn-block">Berlangganan</button>
                        </a>
                    </div>
                </div>
            </div>
        </section>

<section id="faq" class="container my-5">
    <section class="mb-5">
        <h1 class="faq-header">Butuh bantuan? <span class="faq-header-text">Temukan jawabannya di sini.</span></h1>
        <div class="faq-list mt-4">
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqOneHeading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                            <strong>Bagaimana mengatur peran pengguna?</strong>
                        </button>
                    </h2>
                    <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqOneHeading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Untuk mengatur peran pengguna hanya dapat dilakukan oleh admin pada bagian manajemen peran.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqTwoHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                            <strong>Apakah ada uji coba gratis?</strong>
                        </button>
                    </h2>
                    <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faqTwoHeading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami menyediakan uji coba gratis. Anda dapat memulai uji coba gratis untuk mencoba fitur-fitur kami sebelum memutuskan untuk berlangganan. Klik tombol <strong>"Mulai Uji Coba Gratis"</strong> untuk memulai!
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqThreeHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                            <strong>Apa yang membedakan platform ini dari yang lain?</strong>
                        </button>
                    </h2>
                    <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqThreeHeading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Platform ini unggul dengan kombinasi keamanan tinggi, efisiensi operasional, dan kemudahan integrasi. Dilengkapi dengan fitur monitoring kinerja, solusi kami dirancang untuk meningkatkan produktivitas tim Anda secara keseluruhan.
                        </div>
                    </div>
                </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="logo-section">
                        <img src="{{ asset('images/tracking.id.png') }}" alt="Tracking.ID Logo" class="logo">
                    </div>
                    <div class="footer-links">
                        <div class="footer-column">
                            <h5>Quick Links</h5>
                            <ul>
                                <li><a href="#beranda">Beranda</a></li>
                                <li><a href="#fitur">Fitur</a></li>
                                <li><a href="#harga">Harga</a></li>
                                <li><a href="#faq">FAQ</a></li>
                                <li><a href="https://trackingidn.wordpress.com/">Blog</a></li>
                                <li><a href="{{ route('bantuan') }}">Hubungi Kami</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h5>Hubungi Kami</h5>
                            <ul>
                                <li><a href="mailto:trackingid.team@gmail.com">Email: trackingid.team@gmail.com</a></li>
                                <li><a href="tel:+62123456789">Telp: +62 123 456 789</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h5>Follow Us</h5>
                            <div class="social-icons">
                                <a href=" https://www.linkedin.com/company/tracking-id/" class="social-icon"><i class="fab fa-linkedin"></i></a>
                                <a href="https://x.com/trackingid_team?t=FnRueExVPS7AKYzy1DGEaw&s=09" class="social-icon"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.instagram.com/tracking_id?igsh=eDA1dm5uODc2bXFt" class="social-icon"><i class="fab fa-instagram"></i></a>
                                <a href="https://trackingidn.wordpress.com/" class="social-icon"><i class="fab fa-wordpress"></i></a>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sections = document.querySelectorAll('section');
                const navLinks = document.querySelectorAll('.navbar-nav .nav-link-scroll');

                window.addEventListener('scroll', function () {
                    let current = '';

                    sections.forEach(section => {
                        const sectionTop = section.offsetTop;
                        const sectionHeight = section.clientHeight;

                        if (pageYOffset >= sectionTop - sectionHeight / 3) {
                            current = section.getAttribute('id');
                        }
                    });

                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === #${current}) {
                            link.classList.add('active');
                        }
                    });
                });
            });
        </script>

        <script>
            document.querySelectorAll('.nav-link-scroll').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    const offsetPosition = targetElement.offsetTop - 100;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                });
            });
        </script>
    </body>
</html>