<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
   <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-seedling"></i>
    </div>
    <div class="sidebar-brand-text mx-3">UrbanGreen</div>
</a>


    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Liens vers les entités Plantes et Type de Plantes -->
    <div class="sidebar-heading">Gestion des Plantes</div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('plants.index') }}">
            <i class="fas fa-seedling"></i>
            <span>Plantes</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('plant-types.index') }}">
            <i class="fas fa-leaf"></i>
            <span>Type de Plantes</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Interface</div>

    <!-- Components & Utilities menus (comme dans ton code) -->

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
