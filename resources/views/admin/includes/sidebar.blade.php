<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
      <div class="sidebar-brand-icon  d-none">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </div>
      <div class="sidebar-brand-text mx-1">Content <sup>Manager</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is('admin')) ? 'active' : '' }}">
    <a class="nav-link" href="{{url('admin/')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ (request()->is('admin/posts')) ? 'active' : '' }}" >
    <a class="nav-link" href="{{url('admin/posts')}}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Posts</span></a>
    </li>

    <li class="nav-item {{ (request()->is('admin/paginas')) ? 'active' : '' }}">
        <a class="nav-link" href="{{url('admin/paginas')}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Páginas</span></a>
        </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

  </ul>
