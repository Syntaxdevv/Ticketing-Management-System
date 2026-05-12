<header id="page-topbar" class="topbar">

    <div class="layout-width">
        <div class="navbar-header">

            <div class="d-flex align-items-center">

                <div class="navbar-brand-box">
                    <a href="{{ url('dashboard') }}" class="logo-link">
                        <span class="logo-mini">TF</span>
                        <span class="logo-text">TicketFlow</span>
                    </a>
                </div>

                <button class="btn btn-icon ms-3 text-white vertical-menu-btn">
                    <i class="ri-menu-line fs-20"></i>
                </button>

            </div>
            <div class="d-flex align-items-center gap-3">

        
                <button class="btn btn-icon topbar-btn">
                    <i class="ri-fullscreen-line fs-20"></i>
                </button>

                <div class="dropdown">

                    <button class="user-btn" data-bs-toggle="dropdown">

                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div class="user-info d-none d-md-block">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">{{ Auth::user()->role ?? 'User' }}</div>
                        </div>

                        <i class="ri-arrow-down-s-line"></i>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="ri-user-line me-2"></i> Profile
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('lock') }}">
                                <i class="ri-lock-line me-2"></i> Lock Screen
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ri-logout-box-r-line me-2"></i> Logout
                            </a>
                        </li>

                    </ul>

                </div>

                <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>

        </div>
    </div>

</header>