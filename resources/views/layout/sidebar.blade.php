<div id="sidebar-nav" class="sidebar d-flex flex-column p-3" style="background-color: #19508C; z-index: 999;">
  <div class="text-center">
      <a class="logo" href="{{ route('dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid" 
        style="max-width: 100%; height: auto;">
      </a>
    </div>
    <nav>
  @if(optional(optional(Auth::user())->role)->role_name != null)
  <a href="{{ route('dashboard') }}" 
     class="nav-link {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}" 
     style="color: #FFFFFF;">
    <i class="fas fa-th-large"></i>
    <span>Dashboard</span>
  </a>
  
  @if(Auth::user()->role->role_name == 'admin')
  <a href="{{ route('admin.management_peran') }}" 
     class="nav-link {{ in_array(Route::currentRouteName(), ['admin.management_peran', 'roles.create', 'roles.edit']) ? 'active' : '' }}" 
     style="color: #FFFFFF;">
    <i class="fas fa-users"></i>
    <span>Manajemen Peran</span>
  </a>
  @endif
  
  @if(Auth::user()->role->haspermission('package_log_activity'))
    <a href="{{ route('activity.history') }}" 
      class="nav-link {{ Route::currentRouteName() === 'activity.history' ? 'active' : '' }}" 
      style="color: #FFFFFF;">
      <i class="fas fa-chart-line"></i>
      <span>Aktivitas</span>
    </a>
  @endif
  
  @if(Auth::user()->role->hasPermission('package_performance'))
  <a href="{{ route('kinerja') }}" 
     class="nav-link {{ Route::currentRouteName() === 'kinerja' ? 'active' : '' }}" 
     style="color: #FFFFFF;">
    <i class="fas fa-tachometer-alt"></i>
    <span>Kinerja</span>
  </a>
  @endif
  
  @if(Auth::user()->role->role_name == 'admin' || (Auth::user()->role->hasPermission('package_workload') && Auth::user()->role->hasPermission('package_leader')))
    <a href="{{ route('teams.index') }}" 
       class="nav-link {{ in_array(Route::currentRouteName(), ['teams.index', 'teams.create', 'teams.edit', 'teams.addMemberForm', 'teams.show', 'teams.tasks.create', 'workload', 'tasks.show']) ? 'active' : '' }}" 
       style="color: #FFFFFF;">
      <i class="fas fa-clipboard-list"></i>
      <span>Beban Kerja</span>
    </a>
  @elseif(Auth::user()->role->hasPermission('package_workload'))
    <a href="{{ route('workload') }}" 
       class="nav-link {{ in_array(Route::currentRouteName(), ['workload', 'tasks.show']) ? 'active' : '' }}" 
       style="color: #FFFFFF;">
      <i class="fas fa-clipboard-list"></i>
      <span>Beban Kerja</span>
    </a>
  @endif
  
  @if(Auth::user()->role->hasPermission('package_reports'))
  <a href="{{ route('reports.index') }}" 
     class="nav-link {{ Route::currentRouteName() === 'reports.index' ? 'active' : '' }}" 
     style="color: #FFFFFF;">
    <i class="fas fa-file-alt"></i>
    <span>Laporan</span>
  </a>
  @endif
  @else
    <a href="{{ route('activity.history') }}" 
      class="nav-link {{ Route::currentRouteName() === 'activity.history' ? 'active' : '' }}" 
      style="color: #FFFFFF;">
    <i class="fas fa-chart-line"></i>
    <span>Aktivitas</span>
    </a>
  @endif

  <hr class="my-4">
  
  <a href="{{ route('settings.index') }}" 
     class="nav-link {{ in_array(Route::currentRouteName(), ['settings.index', 'notifications.index']) ? 'active' : '' }}" 
     style="color: #FFFFFF;">
    <i class="fas fa-cogs"></i>
    <span>Pengaturan</span>
  </a>
  
  <a href="{{ route('bantuan') }}" 
     class="nav-link {{ Route::currentRouteName() === 'bantuan' ? 'active' : '' }}" 
     style="color: #FFFFFF;">
    <i class="fas fa-question-circle"></i>
    <span>Bantuan</span>
  </a>
    <div class="mt-auto">
  <a href="{{ route('logout') }}" class="nav-link" style="display: flex; align-items: center; padding: 12px 15px; margin-bottom: 10px; text-decoration: none; color: #FFFFFF; background-color: #DC3545; border-radius: 5px; transition: background-color 0.3s ease, color 0.3s ease; width: 100%;">
    <i class="fas fa-sign-out-alt" style="width: 25px; text-align: center; font-size: 18px;"></i>
    <span style="margin-left: 10px;">Log Out</span>
      </a>
    </div>
  </div>
<script>
  const sidebar = document.getElementById('sidebar');
  const hamburger = document.getElementById('hamburger');
  const content = document.getElementById('main-content');

  // Toggle sidebar visibility
  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('sidebar-open');
    content.classList.toggle('sidebar-visible');
  });

  // Close sidebar when a link is clicked
  sidebar.addEventListener('click', (event) => {
    if (event.target.tagName === 'A') {
      sidebar.classList.remove('sidebar-open');
      content.classList.remove('sidebar-visible');
    }
  });
</script>
