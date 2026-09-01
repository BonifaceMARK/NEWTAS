<style>
  #header.app-header {
    height: 68px;
    padding: 0 28px;
    background: #ffffff;
    border-bottom: 1px solid #e9edf2;
    box-shadow: 0 2px 12px rgba(31, 45, 61, .06);
  }

  #header.app-header .header-left,
  #header.app-header .header-actions,
  #header.app-header .time-display,
  #header.app-header .profile-trigger {
    display: flex;
    align-items: center;
  }

  #header.app-header .header-left {
    gap: 20px;
  }

  #header.app-header .app-logo {
    gap: 10px;
    color: #1f2937;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: .1px;
  }

  #header.app-header .app-logo img {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    object-fit: cover;
  }

  #header.app-header .toggle-sidebar-btn {
    color: #64748b;
    font-size: 24px;
    cursor: pointer;
    transition: color .2s ease;
  }

  #header.app-header .toggle-sidebar-btn:hover {
    color: #2563eb;
  }

  #header.app-header .header-actions {
    gap: 24px;
  }

  #header.app-header .time-display {
    gap: 8px;
    color: #64748b;
    font-size: 12px;
  }

  #header.app-header .time-display i {
    color: #2563eb;
    font-size: 15px;
  }

  #header.app-header .time-display strong {
    color: #1f2937;
    font-weight: 600;
  }

  #header.app-header .profile-trigger {
    gap: 10px;
    padding: 4px 0;
    color: #1f2937;
  }

  #header.app-header .profile-trigger img {
    width: 34px;
    height: 34px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
  }

  #header.app-header .profile-name {
    max-width: 150px;
    overflow: hidden;
    font-size: 13px;
    font-weight: 600;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  #header.app-header .profile-menu {
    min-width: 210px;
    margin-top: 8px;
    border: 1px solid #e9edf2;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(31, 45, 61, .12);
  }

  #header.app-header .profile-menu .dropdown-header {
    padding: 14px 16px 10px;
  }

  #header.app-header .profile-menu .dropdown-header h6 {
    margin-bottom: 3px;
    color: #1f2937;
  }

  #header.app-header .profile-menu .dropdown-item {
    padding: 10px 16px;
  }

  @media (max-width: 575px) {
    #header.app-header {
      padding: 0 16px;
    }

    #header.app-header .header-actions {
      gap: 12px;
    }

    #header.app-header .time-display {
      display: none;
    }
  }
</style>

<header id="header" class="header fixed-top d-flex align-items-center app-header">
  <div id="pageLoader" class="page-loader" aria-hidden="true">
    <div class="spinner-border spinner-border-sm" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <div class="header-left">
    <i class="bi bi-list toggle-sidebar-btn" aria-label="Toggle navigation"></i>
    <a href="{{ url('/') }}" class="app-logo logo d-flex align-items-center">
      <img src="{{ asset('assets/img/asi_logo.jpg') }}" alt="ASI Inventory logo">
      <span class="d-none d-sm-block">ASI Inventory</span>
    </a>
  </div>

  <nav class="header-nav ms-auto">
    <div class="header-actions">
      <div class="time-display" aria-label="Current time">
        <i class="bi bi-clock"></i>
        <strong id="horas">--:--:--</strong>
      </div>

      @auth
        <div class="nav-item dropdown">
          <a class="nav-link profile-trigger" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('assets/img/pzpx.png') }}" alt="Profile" class="rounded-circle">
            <span class="profile-name d-none d-md-block">{{ Auth::user()->fullname }}</span>
            <i class="bi bi-chevron-down d-none d-md-block"></i>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile-menu">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->fullname }}</h6>
              <span>{{ Auth::user()->role == 9 ? 'Administrator' : 'Employee' }}</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </div>
      @else
        <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">
          <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
        </a>
      @endauth
    </div>
  </nav>
</header>

<script>
  (() => {
    const clock = document.getElementById('horas');

    if (!clock) {
      return;
    }

    const updateClock = () => {
      clock.textContent = new Date().toLocaleTimeString();
    };

    updateClock();
    window.setInterval(updateClock, 1000);
  })();
</script>