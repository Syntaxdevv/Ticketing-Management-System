<div class="app-menu navbar-menu custom-sidebar">

    <div class="navbar-brand-box text-center py-4">
        <a href="{{ url('dashboard') }}" class="text-decoration-none">

            <div class="logo-sm">
                <div class="logo-circle">TS</div>
            </div>

            <div class="logo-lg mt-2">
                <h4 class="logo-text">TicketFlow</h4>
                <span class="logo-sub">Support System</span>
            </div>

        </a>
    </div>

    <div id="scrollbar">
        <ul class="navbar-nav px-3">
    <li class="menu-title">MAIN MENU</li>

    {{-- ADMIN ONLY: Admin Panel --}}
    @if(auth()->user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="ri-shield-user-line"></i>
            <span>Admin Panel</span>
        </a>
    </li>
    @endif

    {{-- AGENT ONLY: Agent Panel --}}
    @if(auth()->user()->role === 'agent')
    <li class="nav-item">
        <a class="nav-link {{ request()->is('agent*') ? 'active' : '' }}" href="{{ route('agent.dashboard') }}">
            <i class="ri-user-star-line"></i>
            <span>Agent Dashboard</span>
        </a>
    </li>
    @endif

    {{-- EVERYONE: General Dashboard & Tickets --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="ri-dashboard-3-line"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('tickets*') ? 'active' : '' }}" href="{{ route('tickets.index') }}">
            <i class="ri-customer-service-2-line"></i>
            <span>My Tickets</span>
        </a>
    </li>
</ul>