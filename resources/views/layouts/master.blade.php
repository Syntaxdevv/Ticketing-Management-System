<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-layout="vertical"
      data-topbar="dark"
      data-sidebar="dark"
      data-sidebar-size="lg"
      data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | TicketFlow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('build/images/iconn.png') }}">
    @include('partials.css')

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 240px;
            --header-height: 70px;
            --bg-main: #0b0f14;
            --bg-sidebar: #0a0e13;
            --bg-card: #151b22;
            --accent: #6366f1;
            --accent-soft: rgba(99,102,241,0.15);
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
        }

        html, body {
            height: 100%;
            margin: 0;
            background: var(--bg-main);
            color: var(--text-main);
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
        }

        #layout-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .app-menu.navbar-menu {
            width: var(--sidebar-width);
            background: var(--bg-sidebar);
            border-right: 1px solid rgba(255,255,255,0.05);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1001;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .logo-circle {
            width: 45px;
            height: 45px;
            margin: auto;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .navbar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            margin-bottom: 4px;
            transition: all 0.2s;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: var(--text-main);
        }

        .navbar-nav .nav-link.active {
            background: var(--accent-soft);
            color: var(--accent);
            font-weight: 600;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: var(--bg-main);
        }

        #page-topbar {
            height: var(--header-height);
            background: rgba(10, 14, 19, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 25px;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.03);
            padding: 6px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 12px;
        }

        .page-content {
            margin-top: var(--header-height);
            padding: 30px;
            flex: 1;
        }

        .menu-title {
            padding: 20px 15px 10px;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .1em;
            opacity: 0.6;
        }

        .logout-button {
            width: 100%;
            padding: 12px;
            background: rgba(239, 68, 68, 0.08);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
        }

        .overflow-auto::-webkit-scrollbar {
            width: 4px;
        }
        .overflow-auto::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div id="layout-wrapper">

        <aside class="app-menu navbar-menu">
            <div class="text-center py-4">
                <a href="{{ url('/') }}" class="text-decoration-none">
                    <div class="logo-circle text-white">TS</div>
                    <div class="mt-2">
                        <div class="fw-bold text-white" style="letter-spacing: 0.5px;">TicketFlow</div>
                        <div style="font-size:10px;color:var(--text-muted);">SUPPORT SYSTEM</div>
                    </div>
                </a>
            </div>

            <div class="flex-grow-1 overflow-auto">
                <ul class="navbar-nav px-3" style="list-style: none; padding: 0;">
                    
                    {{-- CUSTOMER MAIN MENU --}}
                    @if(Auth::check() && !in_array(strtolower(Auth::user()->role), ['admin', 'agent']))
                        <div class="menu-title">Main Menu</div>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                               href="{{ route('dashboard') }}">
                                <i class="ri-dashboard-3-line"></i> Dashboard
                            </a>
                        </li>
                    @endif

                    {{-- ADMINISTRATION (Para sa Admin lang) --}}
                    @if(Auth::check() && strtolower(Auth::user()->role) === 'admin')
                        <div class="menu-title" style="color: #fbbf24;">Administration</div>
                        
                        {{-- DITO NA YUNG DASHBOARD ANALYTICS LINK --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                <i class="ri-pie-chart-2-line"></i> Dashboard Overview
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/tickets*') ? 'active' : '' }}"
                               href="{{ route('admin.tickets.index') }}">
                                <i class="ri-ticket-2-line"></i> Manage All Tickets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                               href="{{ route('admin.users.index') }}">
                                <i class="ri-user-settings-line"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}"
                               href="{{ route('admin.categories.index') }}">
                                <i class="ri-list-settings-line"></i> Ticket Categories
                            </a>
                        </li>
                    @endif

                    {{-- AGENT PANEL --}}
                    @if(Auth::check() && strtolower(Auth::user()->role) === 'agent')
                        <div class="menu-title" style="color: #38bdf8;">Agent Panel</div>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('agent/dashboard*') ? 'active' : '' }}"
                               href="{{ route('agent.dashboard') }}">
                                <i class="ri-dashboard-line"></i> Agent Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('agent/tickets*') ? 'active' : '' }}"
                               href="{{ route('agent.tickets.index') }}">
                                <i class="ri-briefcase-4-line"></i> Assigned To Me
                            </a>
                        </li>
                    @endif

                    {{-- SUPPORT (Para sa Customer) --}}
                    @if(Auth::check() && !in_array(strtolower(Auth::user()->role), ['admin', 'agent']))
                        <div class="menu-title">Support</div>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('tickets*') && !request()->is('admin*') && !request()->is('agent*')) ? 'active' : '' }}"
                               href="{{ route('tickets.index') }}">
                                <i class="ri-coupon-line"></i> My Tickets
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="mt-auto p-3 border-top border-white border-opacity-10">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="ri-logout-box-r-line"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="main-content">
            <header id="page-topbar">
                <div style="margin-left:auto; display:flex; align-items:center;">
                    <div class="user-box">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                        </div>
                        <div class="d-none d-md-block text-start">
                            <div class="fw-bold text-white" style="line-height: 1.2; font-size: 13px;">{{ Auth::user()->name }}</div>
                            <div style="font-size:10px; color:var(--text-muted); text-transform: capitalize;">
                                {{ Auth::user()->role }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    @include('partials.scripts')
    @stack('scripts')

</body>
</html>