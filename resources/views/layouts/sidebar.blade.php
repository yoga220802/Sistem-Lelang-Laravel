<!-- FILE: resources/views/layouts/sidebar.blade.php -->

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SISTEM LELANG KELOMPOK 6</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - User Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
            aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-user"></i>
            <span>User</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingUser" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management:</h6>
                <a class="collapse-item" href="{{ route('users.index') }}">Display User</a>
                <a class="collapse-item" href="{{ route('users.create') }}">Add Admin</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Item Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseItem"
            aria-expanded="true" aria-controls="collapseItem">
            <i class="fas fa-fw fa-box"></i>
            <span>Item</span>
        </a>
        <div id="collapseItem" class="collapse" aria-labelledby="headingItem" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Item Management:</h6>
                <a class="collapse-item" href="{{ route('items.index') }}">Display Items</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Auctions Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAuctions"
            aria-expanded="true" aria-controls="collapseAuctions">
            <i class="fas fa-fw fa-gavel"></i>
            <span>Auctions</span>
        </a>
        <div id="collapseAuctions" class="collapse" aria-labelledby="headingAuctions" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Auction Management:</h6>
                <a class="collapse-item" href="{{ route('auctions.index') }}">Display Auctions</a>
                <a class="collapse-item" href="{{ route('items.create') }}">Add Auction</a>
                <a class="collapse-item" href="{{ route('auctions.notStarted') }}">Not Started Auctions</a>
                <a class="collapse-item" href="{{ route('auctions.completed') }}">Completed Auctions</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
