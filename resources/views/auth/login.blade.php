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

        .btn-login {
            background-color: #1098F7;
            color: white;
            border-radius: 5px;
            padding: 7px 0;
            font-size: 1.1rem;
            width: 40%;
        }

        .btn-login:hover {
            background-color: #0877C3;
        }

        .btn-register {
            border: 2px solid #1098F7;
            color: white;
            background-color: rgba(16, 152, 247, 0.2);
            border-radius: 5px;
            padding: 7px 40px;
            font-size: 1.1rem;
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
    </style>
</head>

<body>
    <div class="d-flex vh-100 flex-row">
        <!-- Bagian Kiri - Login Form -->
        <div class="w-50 d-flex flex-column justify-content-center align-items-center left-section">
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
                    <input type="email" name="email" placeholder="Email" class="form-control p-3" style="border-radius: 5px;" required>
                    <input type="password" name="password" placeholder="Password" class="form-control p-3" style="border-radius: 5px;" required>
                    <div class="d-flex justify-content-between">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input me-2"> Simpan Login Saya
                        </label>
                        <a href="{{ route('forgot.password') }}" class="text-primary">Lupa Password</a>
                    </div>
                    <button type="submit" class="btn fw-semibold btn-login mx-auto" style="background-color:#19508C">Login</button>
                </form>
            </div>

            <div class="d-flex align-items-center my-4 w-75">
                <hr class="flex-grow-1">
                <span class="mx-3 text-secondary">Atau</span>
                <hr class="flex-grow-1">
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center social-icon">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center social-icon">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center social-icon">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>

        <!-- Bagian Kanan - Register -->
        <div class="w-50 d-flex flex-column justify-content-center align-items-center text-white px-5"
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