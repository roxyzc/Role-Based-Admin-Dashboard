@extends('layout.main')

@section('title', 'Notifikasi')

@section('content')
<style>
    .notification-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f8f9fa;
      padding: 10px 20px;
      border-bottom: 1px solid #ddd;
      font-weight: bold;
    }

    .notification-header span:first-child {
        font-size: 1.5rem;
    }

    .notification-header .mark-read {
      color: #007bff;
      cursor: pointer;
      font-size: 1rem; 
    }

    .notification-header .mark-read:hover {
      text-decoration: none;
    }

    .notification-item {
      padding: 15px;
      border-bottom: 1px solid #ddd;
      background-color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .notification-item.unread {
      background-color: #e9f7ff;
      transition: background-color 0.3s, box-shadow 0.3s;
    }

    .notification-item.unread:hover {
      background-color: #f0f8ff;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      cursor: pointer;
    }
    
    .notification-item.read {
      background-color: #ffffff;
    }

    .notification-icon {
      margin-right: 10px;
      font-size: 20px;
    }

    .confirmation-message {
      display: none;
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 14px;
      z-index: 1000;
    }

    .notification-time {
      font-size: 12px;
      color: #888;
    }

    .notification-content {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .notification-text {
      font-size: 14px;
      margin-bottom: 5px;
    }

    .pagination {
        justify-content: center;
        list-style: none;
        padding-left: 0;
        display: flex;
        gap: 5px;
    }

    .pagination li {
        display: inline;
    }

    .pagination li a, .pagination li span {
        color: #007bff;
        text-decoration: none;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .pagination li a:hover, .pagination li span:hover {
        background-color: #e9f7ff;
        text-decoration: none;
    }

    .pagination .active a, .pagination .active span {
        background-color: #055994;
        color: white;
        border-color: #055994;
    }

    .pagination .disabled a, .pagination .disabled span {
        color: #ccc;
        border-color: #ddd;
    }
</style>

<div class="flex-grow-1 d-flex flex-column">
  <div class="d-flex justify-content-start align-items-center gap-3 ps-4" style="margin-top: 120px;">
    <a href="{{ route('settings.index') }}" class="btn fs-6" style="font-weight: bold; color: #FFFFFF; background-color: #19508C; border-color: #19508C;">&lt;</a>
    <div class="d-flex align-items-center">
        <span class="text-muted">Home &gt;</span>
        <div class="text-muted ms-2">
          Pengaturan &gt;
        </div>
        <div class="text-muted ms-2">Notifikasi</div>
    </div>
  </div>
  <div class="text-left mb-4 mt-5 px-4">
      <ul class="nav nav-pills border-bottom" style="display: flex; gap: 5px;">
          <li class="nav-item">
              <a class="nav-link active" href="{{ route('settings.index') }}" style="background-color:#19508C;">Pengaturan Akun</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="{{ route('notifications.index') }}" style="background-color: white; color: #19508C; box-shadow: inset 0 0 0 2px #19508C;  ">Notifikasi</a>
          </li>
      </ul>
  </div>

  <div class="container mb-5 ms-3 px-2">
      <div class="notification-header" style="background-color:#19508C; border-radius: 10px;">
              <span style="color: #ffffff;; font-weight: bold;">Notifikasi</span>
              <span class="mark-read" id="markReadBtn" style="color: #ffffff;">Sudah Dibaca</span>
          </div>
            <div id="notificationList">
              @if($notifications->count() > 0) 
                @foreach ($notifications as $notification)
                  <div class="notification-item {{ $notification->status == 'read' ? 'read' : 'unread' }}" data-type="{{ $notification->type }}" data-id="{{ $notification->id }}">
                      <div class="d-flex align-items-center">
                          <i class="bi bi-info-circle-fill notification-icon"></i>
                          <div class="notification-content">
                              <strong class="notification-text">{{ $notification->title }}</strong>
                              <p class="notification-text">{!! $notification->message !!}</p>
                              <span class="notification-time">{{ $notification->created_at->translatedFormat('l, d F Y H:i') }}</span>
                          </div>
                      </div>
                  </div>
                @endforeach          
              @else
                <div class="alert alert-danger text-center mt-2">
                  <strong>Saat ini tidak ada notifikasi.</strong>
                </div>
              @endif
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links('pagination::bootstrap-4') }}
            </div>

            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="confirmation-message" id="confirmationMessage">
              <span>Pesan telah dibaca semua</span>
            </form>
          
            <button id="markReadBtn" style="display: none;">Mark All as Read</button>
        </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        let $confirmationMessage = $('#confirmationMessage');
        $confirmationMessage.hide();

        function checkUnreadNotifications() {
            if ($('.notification-item.unread').length === 0) {
                $('#notifDot').css('display', 'none');
            }
        }

        $('#markReadBtn').on('click', function() {
            let $notifications = $('.notification-item');
            $notifications.each(function() {
                $(this).removeClass('unread').addClass('read');
            });

            $confirmationMessage.show();

            setTimeout(function() {
                $confirmationMessage.hide();
            }, 3000);

            $.ajax({
                url: "{{ route('notifications.markAllAsRead') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#notifDot').css('display', 'none');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('.notification-item').on('click', function() {
          let notificationId = $(this).data('id');
          let $this = $(this);

          $.ajax({
              url: '/notification/' + notificationId + '/read',
              method: 'POST',
              data: {
                  _token: '{{ csrf_token() }}',
              },
              success: function(response) {
                  $this.removeClass('unread').addClass('read');

                  checkUnreadNotifications();
              },
              error: function(xhr, status, error) {
                  console.error('Error:', error);
              }
          });
        });
    });
  </script>
@endsection
