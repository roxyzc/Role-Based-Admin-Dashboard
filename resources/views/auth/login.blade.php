<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #E6F4FE;
            margin: 0;
            padding: 0;
        }

        .form-control {
            border-radius: 18px;
            width: 100%;
            max-width: 542px;
            margin: 0 auto;
        }

        .btn-login {
            background-color: #19508C;
            color: white;
            padding: 7px 0;
            font-size: 1.1rem;
            width: 38%;
            height: 45px;
            border-radius: 18px;
        }

        .btn-login:hover {
            background-color: #174171;
            color: #E6F4FE;
        }

        .btn-register {
            border: 2px solid #1098F7;
            color: white;
            background-color: rgba(16, 152, 247, 0.2);
            border-radius: 18px;
            padding: 7px 40px;
            font-size: 1.1rem;
            width: 28%;
            height: 45px;
        }

        .btn-register:hover {
            background-color: rgba(16, 152, 247, 0.4);
        }

        .form-container {
            width: 90%;
            max-width: 500px;
        }

        .social-icon {
            border: 2px solid black;
            width: 40px;
            height: 40px;
        }

        a.text-primary {
            text-decoration: none;
        }

        .left-section {
            background-color: #E6F4FE;
        }

        @media (max-width: 768px) {
            .btn-login {
                width: 80%;
            }

            .btn-register {
                width: 80%;
            }

            .form-container {
                width: 90%;
            }

            .left-section {
                padding: 20px;
            }

            .col-12.col-md-6 {
                padding: 10px;
            }

            .form-control {
                max-width: 100%;
            }

            .social-icon {
                width: 35px;
                height: 35px;
            }

            .d-flex {
                flex-direction: row;
                justify-content: center;
                gap: 10px;
            }

            .form-container h2 {
                margin-bottom: 20px;
            }

            .btn-register {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .btn-login {
                width: 90%;
            }

            .btn-register {
                width: 100%;
            }

            .form-container {
                width: 90%;
            }

            .social-icon {
                width: 30px;
                height: 30px;
            }

            .d-flex {
                flex-direction: row;
                justify-content: center;
                gap: 8px;
            }

            .form-container h2 {
                margin-top: 160px;
            }
        }
    </style>
</head>

<body>
<div class="d-flex flex-column flex-md-row vh-100">
    <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center left-section">
            <a href="{{ route('landing.page') }}" class="position-absolute top-0 start-0 p-4 text-primary fs-4 fw-bold">
                <img src="{{ asset('images/tracking.id.png') }}" alt="logo" class="img-fluid" style="max-width: 200px">
            </a>
            
            <div class="form-container">
                <h2 class="fs-2 fw-bold mb-4 text-center text-dark">Login disini</h2>

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

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <ul class="mb-0 list-unstyled">
                        <li class="small">{{ session('success') }}</li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <input type="email" name="email" placeholder="Email" class="form-control p-3"required>
                    <input type="password" name="password" placeholder="Password" class="form-control p-3"required>
                    <div class="d-flex justify-content-between">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input me-2"> Simpan Login Saya
                        </label>
                        <a href="{{ route('forgot.password') }}" class="text-primary">Lupa Password</a>
                    </div>
                    <button type="submit" class="btn fw-semibold btn-login mx-auto">Login</button>
                </form>
            </div>

            <div class="d-flex align-items-center my-4 w-75">
                <hr class="flex-grow-1">
                <span class="mx-3 text-secondary">Atau</span>
                <hr class="flex-grow-1">
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="https://www.facebook.com" target="_blank">
                    <img src="{{ asset('images/logofacebook.png') }}" alt="Facebook" style="width: 40px; height: 40px;">
                </a>
                <a href="https://www.login.com" target="_blank">
                    <img src="{{ asset('images/logogoogle.png') }}" alt="Google" style="width: 40px; height: 40px;">
                </a>
            </div>
        </div>

    <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center text-white px-5"
        style="background-image: url('{{ asset('images/login.png') }}'); background-size: cover; background-position: center;">
            <h2 class="text-center fw-bold display-5 mb-4">
                <div>Login Untuk</div>
                <div>Melihat Kinerja</div>
            </h2>
            <p class="text-center mb-4">
                <div>Jika Anda belum memiliki akun, daftar sekarang dan mulai</div>
                <div>optimalkan performa tim Anda</div>
            </p>
            <a href="{{ route('register') }}" class="btn btn-register">Register</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>