<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Kata Sandi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid" style="height: 100vh;">
  <div class="row" style="height: 100%;">
    <!-- Bagian Gambar -->
    <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #ffffff; padding: 0;">
      <img src="{{ asset('images/pww.jpg') }}" alt="Gambar Lupa Kata Sandi" class="img-fluid" style="margin: 0;">
    </div>

    <!-- Bagian Form -->
    <div class="col-md-6 d-flex flex-column justify-content-center" style="background-color: #E6F4FE; padding: 0 50px;">
      <h2 class="fs-2 fw-bold mb-4 text-center text-dark">Lupa Password Anda?</h2>
      <p class="text-center mb-4">Masukkan alamat email Anda untuk mengatur ulang password</p>
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
      <form action="{{ route('forgot.password') }}" method="POST">
        @csrf
        <div class="mb-2">
          <input type="email" name="email" class="form-control p-3" style="border-radius: 5px;" id="email" placeholder="Alamat Email Anda" required>
        </div>
        <button type="submit" class="btn w-100" style="margin-top: 5px; background-color:#19508C; color: white; border: none;">Kirim</button>
      </form>
      <div class="text-center" style="margin-top: 20px; color: #6c757d;">
        <a href="{{ route('login') }}" style="text-decoration: none; color: #007bff;">Kembali ke login</a>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>