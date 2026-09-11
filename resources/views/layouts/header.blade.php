{{-- filepath: c:\xampp\htdocs\ASI-INVENTORY\resources\views\layouts\header.blade.php --}}

<style>
    #header.app-header {
        height: 68px;
        padding: 0 24px;
        background: #fff;
        border-bottom: 1px solid #e6edf5;
        box-shadow: 0 2px 14px rgba(18, 59, 120, .06);
    }

    #header.app-header .header-left,
    #header.app-header .header-actions,
    #header.app-header .time-display,
    #header.app-header .profile-trigger { display: flex; align-items: center; }

    #header.app-header .header-left { gap: 14px; }

    #header.app-header .toggle-sidebar-btn {
        padding: 7px;
        color: #64748b;
        border-radius: 8px;
        cursor: pointer;
        font-size: 21px;
        transition: .2s ease;
    }

    #header.app-header .toggle-sidebar-btn:hover { color: #1769aa; background: #eef5fc; }
    #header.app-header .app-logo { gap: 9px; color: #123b78; font-size: 17px; font-weight: 700; letter-spacing: -.25px; }
    #header.app-header .app-logo img { width: 34px; height: 34px; border: 1px solid #e6edf5; border-radius: 9px; object-fit: cover; }
    #header.app-header .header-actions { gap: 18px; }

    #header.app-header .time-display {
        gap: 7px;
        padding: 7px 10px;
        color: #718096;
        border: 1px solid #edf1f6;
        border-radius: 8px;
        font-size: 12px;
    }

    #header.app-header .time-display i { color: #1769aa; }
    #header.app-header .time-display strong { color: #334155; font-weight: 600; }
    #header.app-header .profile-trigger { gap: 9px; padding: 5px 7px; color: #334155; border-radius: 9px; }
    #header.app-header .profile-trigger:hover { background: #f6f9fc; }
    #header.app-header .profile-trigger img { width: 34px; height: 34px; border: 2px solid #dce8f5; object-fit: cover; }
    #header.app-header .profile-name { max-width: 150px; overflow: hidden; font-size: 13px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }

    #header.app-header .profile-menu {
        min-width: 210px;
        margin-top: 8px;
        padding: 5px 0;
        border: 1px solid #e6edf5;
        border-radius: 10px;
        box-shadow: 0 12px 30px rgba(18, 59, 120, .12);
    }

    #header.app-header .profile-menu .dropdown-header { padding: 12px 15px 9px; }
    #header.app-header .profile-menu .dropdown-header h6 { margin-bottom: 3px; color: #123b78; }
    #header.app-header .profile-menu .dropdown-item { padding: 9px 15px; }
    #header.app-header .profile-menu .dropdown-item:hover { color: #1769aa; background: #eef5fc; }

    @media (max-width: 575px) {
        #header.app-header { padding: 0 12px; }
        #header.app-header .header-actions { gap: 5px; }
        #header.app-header .time-display { display: none; }
    }
</style>

<header id="header" class="header fixed-top d-flex align-items-center app-header">
    <div id="pageLoader" class="page-loader" aria-hidden="true">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="header-left">
        <i class="bi bi-list toggle-sidebar-btn" aria-label="Toggle navigation" role="button" tabindex="0"></i>
        <a href="{{ url('/') }}" class="app-logo logo d-flex align-items-center">
            <img src="{{ asset('assets/img/asi_logo.jpg') }}" alt="ASI Inventory logo">
            <span>AD Inventory</span>
        </a>
    </div>

    <nav class="header-nav ms-auto" aria-label="User navigation">
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

                    <ul class="dropdown-menu dropdown-menu-end profile-menu">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->fullname }}</h6>
                            <span>{{ Auth::user()->role == 9 ? 'Administrator' : 'Employee' }}</span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i><span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
                </a>
            @endauth
        </div>
    </nav>
</header>

<script>
    (() => {
        const clock = document.getElementById('horas');
        if (!clock) return;
        const updateClock = () => { clock.textContent = new Date().toLocaleTimeString(); };
        updateClock();
        window.setInterval(updateClock, 1000);
    })();
</script>
