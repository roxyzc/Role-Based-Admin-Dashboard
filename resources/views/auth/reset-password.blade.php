<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atur Ulang Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      .form-control {
        border-radius: 18px;
        width: 100%;
        max-width: 542px;
        margin: 0 auto;
      }

      .btn {
        border-radius: 18px;
        width: 100%;
        max-width: 542px;
        padding: 0.75rem 1rem;
        background-color: #19508C;
        color: white;
        border: 1px solid #19508C;
        transition: background-color 0.3s ease, color 0.3s ease;
        margin: 0 auto;
        display: block;
      }

      .btn:hover {
        background-color: #174171;
        color: #E6F4FE;
      }
  </style>
  
</head>
<body>
<div class="container-fluid" style="height: 100vh;">
  <div class="row" style="height: 100%;">
    <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #ffffff; padding: 0;">
      <img src="{{ asset('images/email.jpg') }}" alt="Gambar Lupa Kata Sandi" class="img-fluid" style="margin: 0;">
    </div>

    <div class="col-md-6 d-flex flex-column justify-content-center" style="background-color: #E6F4FE; padding: 0 50px;">
      <h2 class="fs-2 fw-bold mb-4 text-center text-dark">Atur ulang password Anda</h2>

      @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-2" style="max-width: 542px;  width: 100%; margin: 0 auto; border-radius: 18px;" role="alert">
          <ul class="mb-0 list-unstyled">
              @foreach ($errors->all() as $error)
                  <li class="small">{{ $error }}</li>
              @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <form action="{{ route('reset.password') }}" method="POST" id="resetPasswordForm">
        @csrf
        <input type="hidden" name="token" id="token">
        
        <div class="mb-4">
          <input type="password" name="password" class="form-control p-3 mb-3" id="newPassword" placeholder="Masukkan password baru Anda" required>
          <input type="password" name="confirm_password" class="form-control p-3 mb-3" id="confirmPassword" placeholder="Konfirmasi password baru Anda" required>
        </div>
        
        <button type="submit" class="btn w-100">Kirim</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function getTokenFromUrl() {
    const path = window.location.pathname;
    const segments = path.split('/'); 

    return segments[segments.length - 1];
  }

  window.onload = function() {
    const token = getTokenFromUrl();
    if (token) {
      document.getElementById('token').value = token;
    }
  };
</script>
</body>
</html>