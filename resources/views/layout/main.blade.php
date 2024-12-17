<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      background-color: #19508C;
      color: white;
      transition: left 0.3s ease-in-out;
      z-index: 1000;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar h1 {
      font-weight: bold;
      margin: 20px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      padding: 12px 15px;
      margin-bottom: 10px;
      text-decoration: none;
      color: #333;
      border-radius: 5px;
      transition: background-color 0.3s, color 0.3s;
    }

    .sidebar a i {
      width: 25px;
      text-align: center;
      font-size: 18px;
    }

    .sidebar a span {
      margin-left: 10px;
    }

    .sidebar a.nav-link:hover,
    .sidebar a.active {
      background-color: #CFE4FB80;
      color: #000000;
    }

    .sidebar a.nav-link:hover i,
    .sidebar a.active i,
    .sidebar a.nav-link:hover span,
    .sidebar a.active span {
      color: #000000;
    }

    .sidebar-open {
      left: 0;
    }

    .content {
      padding: 20px;
      margin-left: 0;
      transition: margin-left 0.3s ease-in-out;
    }

    .content.sidebar-visible {
      margin-left: 250px;
    }

    .hamburger {
      font-size: 24px;
      cursor: pointer;
      color: #19508C;
      position: absolute;
      left: 30px; 
      margin: 0 auto; 
      text-align: left;
      top: 42px; 
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 250px;
        height: 100%; 
        position: fixed;
        left: -250px;
        top: 0;
        transition: left 0.3s ease-in-out;
        z-index: 1000;
      }

      .sidebar.show {
        left: 0;
      }

      .content {
        margin-left: 0; 
      }

      .content.sidebar-visible {
        margin-left: 250px;
      }

      .logo {
        display: block; 
        margin: 0 auto; 
        text-align: center; 
        position: relative; 
        z-index: 9999; 
        left: 20px;
      }

      .header {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        z-index: 9999;
        transition: left 0.3s ease-in-out;
      }

      .header.sidebar-visible {
        left: 250px;
      }

      .header .text-black {
        display: none;
      }

      .text-black {
        display: none !important;
        gap: 13px;
      }

      .text-decoration {
        left: 29px;
      }

      .btn {
        gap: 13px;
      }
    }

    @media (min-width: 768px) {
      .sidebar {
        left: 0;
      }

      .content {
        margin-left: 250px;
      }

      .hamburger {
        display: none;
      }

      .logo {
        display: none; 
      }

      .header {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 9999;
      }
    }
  </style>
</head>

<body class="bg-light">
  @if(Auth::check())
    @include('layout.sidebar')
  @endif

  @if(Auth::check())
  <header 
  class="d-flex justify-content-end align-items-center shadow-sm"
  style="position: fixed; left: 0px; top: 0; right: 0; height: 108px; background-color: #FFFFFF; padding: 0 40px; margin: 0; z-index: 998; box-sizing: border-box;">
  <div class="d-flex align-items-center gap-4">
    <div class="header">
      <i id="hamburger" class="fas fa-bars hamburger"></i> 
    </div>
    <div class="logo">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
    </div>

    @if(optional(optional(Auth::user())->role)->role_name != null)
      @if(Auth::user()->role->role_name != 'admin')
        <a href="{{ route('monetisasi.index') }}" class="btn position-relative" style="padding: 0; display: flex; align-items: center;">
          <i class="fas fa-crown fs-4" style="color: #055994;"></i>
        </a>
      @endif

      @if(Auth::user()->role->hasPermission('package_notification'))
      <a href="{{ route('notifications.index') }}" class="btn position-relative" style="padding: 0; display: flex; align-items: center;">
        <span class="material-icons fs-4" style="color: #055994;">notifications</span>
        @if(Optional($unreadNotificationsCount)? $unreadNotificationsCount : 0 > 0) 
          <span id="notifDot" class="position-absolute bg-danger rounded-circle" 
          style="width: 5px; height: 5px; top: 4px; right: 4px;"></span>
        @endif
      </a>
      @endif
    @endif
    
    <a href="{{ route('settings.index') }}" class="text-decoration-none">
      <img 
        src="{{ Auth::user()->profile_picture ? asset('storage/'. explode('public/', Auth::user()->profile_picture)[1]) : asset('images/profile.png') }}" 
        alt="User" 
        class="rounded-circle" 
        style="width: 40px; height: 40px; object-fit: cover;">
      <span class="ms-2 text-black">{{ Auth::user()->first_name ? ucwords(Auth::user()->first_name . ' ' . Auth::user()->last_name) : ucwords(Auth::user()->username) }}</span>
    </a>
  </div>
</header>
  @endif
  
  <div class="content">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const sidebar = document.querySelector('.sidebar');
      const hamburger = document.querySelector('#hamburger');
      const content = document.querySelector('.content');
      const header = document.querySelector('.header');

      hamburger.addEventListener('click', function () {
        sidebar.classList.toggle('show'); 
        content.classList.toggle('sidebar-visible'); 
        header.classList.toggle('fixed');  
      });

      document.addEventListener('click', function (event) {
        if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
          sidebar.classList.remove('show');
          content.classList.remove('sidebar-visible'); 
          header.classList.remove('fixed'); 
        }
      });
    });
    
  </script>
</body>

</html>