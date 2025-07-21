<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('vila.index') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-home"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/master">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if(auth()->user()->role === 'admin')
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">Admin Menu</div>

        <!-- Data Vila -->
        <li class="nav-item {{ Request::is('vila') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('vila.index') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Data Vila</span>
            </a>
        </li>

        <!-- Tambah Vila -->
        <li class="nav-item {{ Request::is('vila/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('vila.create') }}">
                <i class="fas fa-fw fa-plus"></i>
                <span>Tambah Vila</span>
            </a>
        </li>

        <!-- Info Bookingan -->
        <li class="nav-item {{ Request::is('/calendar') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('calendarVilla') }}">
                <i class="far fa-fw fa-calendar-alt"></i>
                <span>Info Bookingan</span>
            </a>
        </li>

        <!-- Info Tanggal -->
        <li class="nav-item {{ Request::is('/calendar') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('vila.calendar') }}">
                <i class="far fa-fw fa-calendar"></i>
                <span>Info Tanggal</span>
            </a>
        </li>
            <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline mt-2">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    @endif

    @if(auth()->user()->role === 'superadmin')
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">Super Admin</div>

        <!-- Data Villa Owner -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dataVilla') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Data Villa Owner</span>
            </a>
        </li>

        <!-- Kelola User -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('superadmin.index') }}">
                <i class="fas fa-fw fa-users-cog"></i>
                <span>Kelola User</span>
            </a>
        </li>
            <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline mt-2">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    @endif

</ul>
<!-- End of Sidebar -->
