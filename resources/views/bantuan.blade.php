@extends('layout.main')

@section('title', 'Bantuan dan Dukungan')

@if (Auth::check())
    @section('content')
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
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
            font-size: 18px;
        }

        .accordion-body {
            font-size: 16px;
        }

        .faq-title {
            font-size: 32px;
        }

        .btn-link {
            font-size: 16px;
            text-decoration: none !important;
            color: #6c757d;
            font-weight: 400;
            border: none;
            background: transparent;
            padding: 0;
        }

        .btn-link:hover {
            text-decoration: none !important;
            color: #6c757d;
        }

        .btn-link .material-icons {
            font-size: 14px;
            vertical-align: middle;
        }

        @keyframes slideDown {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

        @keyframes slideUp {
            from { transform: scaleY(1); }
            to { transform: scaleY(0); }
        }

        .contact-card {
            max-width: 400px;
            width: 100%;
            margin: 30px auto;
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #76c4ee, #3a97d1);
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .contact-card p {
            font-size: 14px;
            color: #ffffff;
        }

        .contact-icons {
            justify-content: center;
        }

        .contact-icons a {
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px; 
            width: 40px; 
            height: 40px;
            border-radius: 50%;
            margin: 0 8px;
            text-decoration: none;
        }

        .contact-icons a.email {
            background-color: #007bff;
        }

        .contact-icons a.whatsapp {
            background-color: #25d366;
        }

        .contact-icons a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex">
        <div class="flex-grow-1 d-flex flex-column" style="margin-left: 0;">
            @if($user == NULL)
            <div style="margin-bottom: 120px;">
                <header class="d-flex justify-content-between align-items-center shadow-sm p-3"
                        style="position: fixed; top: 0; left: 0; right: 0; background-color: #FFFFFF; padding: 0 20px; z-index: 999; box-sizing: border-box;">
                    <a class="navbar-brand" href="{{ route('landing.page') }}">
                        <img src="{{ asset('images/tracking.id.png') }}" alt="Tracking.ID Logo" class="img-fluid" style="max-height: 30px;">
                    </a>
                    <div class="d-flex align-items-center gap-4">
                        <a href="{{ route('notifications.index') }}" class="btn position-relative" style="padding: 0;">
                            <span class="material-icons fs-4" style="color: #055994;">notifications</span>
                        </a>
                        <a href="{{ route('settings.index') }}" class="text-decoration-none d-flex align-items-center">
                            <img src="{{ asset('images/profile.png') }}" alt="User" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            <span class="ms-2 text-black">User</span>
                        </a>
                    </div>
                </header>
            </div>            
            @endif

            @if($user)
                <div class="d-flex justify-content-start align-items-center gap-3" style="margin-top: 120px;">
                    <a href="{{ url()->previous() }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
                    <div class="d-flex align-items-center">
                        <span class="text-muted">Home &gt;</span> 
                        <span class="text-muted ms-2">Bantuan</span>
                    </div>
                </div>
            @endif

            <main class="container my-5">
                <section>
                    <h2 class="mb-4 text-center faq-title">FAQs</h2>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faqOneHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                                    <strong>Bagaimana cara mendaftar akun?</strong>
                                </button>
                            </h2>
                            <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqOneHeading" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk mendaftar akun, klik tombol <strong>Daftar</strong> di halaman utama, isi informasi yang diperlukan, lalu klik <strong>Buat Akun</strong>.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faqTwoHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                                    <strong>Apa yang harus dilakukan jika lupa kata sandi?</strong>
                                </button>
                            </h2>
                            <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faqTwoHeading" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Klik tautan <strong>Lupa Kata Sandi</strong> di halaman login, masukkan email Anda, dan ikuti petunjuk untuk mereset kata sandi Anda.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faqThreeHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                                    <strong>Bagaimana cara menghubungi dukungan?</strong>
                                </button>
                            </h2>
                            <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqThreeHeading" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Anda dapat menghubungi dukungan kami melalui email di trackingid.team@gmail.com atau melalui WhatsApp di 123-456-7890.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="text-center my-5">
                    <div class="contact-card">
                        <p>Jika Anda membutuhkan bantuan lebih lanjut, jangan ragu untuk menghubungi kami!</p>
                        <div class="contact-icons d-flex justify-content-center">
                            <a href="mailto:trackingid.team@gmail.com" class="email">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                            <a href="https://wa.me/1234567890" class="whatsapp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@if(Auth::check())
    @endsection
@endif