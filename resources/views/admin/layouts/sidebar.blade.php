<?php
// set collapsed class
function isCollapsed(array $controllerNameArray)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if (!in_array($current_controller, $controllerNameArray)) {
        echo 'collapsed';
    }
}
// set active class in li tag
function isActiveLI($controllerName)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if ($current_controller == $controllerName) {
        echo 'active';
    }
}
// set show class in a tag
function isShow($controllerName)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if ($current_controller == $controllerName) {
        echo 'show';
    }
}
// set active class
function isActive($routeName)
{
    if (Route::currentRouteName() == $routeName) {
        echo 'active';
    }
}
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Laravel Starter</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - role management -->
  @canany(['dashboard'])
    <li class="nav-item {{ isActiveLI('dashboard') }}">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
  @endcanany

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading mb-2">
    User &amp; Role Management
  </div>
  {{-- @if (menuPermission('admin.role.all'))
    <li class="nav-item {{ isActiveLI('admin') }}">
      <a class="nav-link" href="{{ route('admin.role.all') }}">
        <i class="fas fa-users-cog"></i>
        <span>Role Management</span></a>
    </li>
  @endif --}}

  {{-- Nav item -permission management --}}
  @canany(['permissions-edit', 'permissions-list', 'permissions-create', 'permissions-delete'])
    <li class="nav-item {{ isActiveLI('permissions') }}">
      <a class="nav-link {{ isCollapsed(['permissions']) }}" href="{{ route('permissions.index') }}">
        <i class="fas fa-shield-alt"></i>
        <span>Permission Management</span>
      </a>
    </li>
  @endcanany


  {{-- Nav item -role managements --}}
  @canany(['roles-edit', 'roles-list', 'roles-create', 'roles-delete'])
    <li class="nav-item {{ isActiveLI('roles') }}">
      <a class="nav-link {{ isCollapsed(['roles']) }}" href="{{ route('roles.index') }}">
        <i class="fas fa-user-shield"></i>
        <span>Role Management</span>
      </a>
    </li>
  @endcanany


  @canany(['users-edit', 'users-list', 'users-create', 'users-delete'])
    <li class="nav-item {{ isActiveLI('users') }}">
      <a class="nav-link" href="{{ route('users.index') }}">
        <i class="fas fa-users"></i>
        <span>User Management</span></a>
    </li>
  @endcanany

  <!-- Heading -->
  {{-- <div class="sidebar-heading">
    Role &amp; Permission Management
  </div> --}}

  <!-- Nav Item - Pages Collapse Menu -->
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
      aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Custom Components:</h6>
        <a class="collapse-item" href="buttons.html">Buttons</a>
        <a class="collapse-item" href="cards.html">Cards</a>
      </div>
    </div>
  </li> --}}

  <!-- Nav Item - Utilities Collapse Menu -->
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
      aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Utilities</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Custom Utilities:</h6>
        <a class="collapse-item" href="utilities-color.html">Colors</a>
        <a class="collapse-item" href="utilities-border.html">Borders</a>
        <a class="collapse-item" href="utilities-animation.html">Animations</a>
        <a class="collapse-item" href="utilities-other.html">Other</a>
      </div>
    </div>
  </li> --}}

  {{-- <li class="nav-item {{ isActiveLI('production-materials') }} {{ isActiveLI('production-material-requests') }}">
    <a class="nav-link {{ isCollapsed(['production-materials', 'production-material-requests']) }}" href="#"
      data-toggle="collapse" data-target="#productionMatMenu" aria-expanded="true" aria-controls="productionMatMenu">
      <i class="fas fa-industry"></i>
      <span>Production Materials</span>
    </a>
    <div id="productionMatMenu"
      class="collapse {{ isShow('production-materials') }} {{ isShow('production-material-requests') }}"
      aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Prod Mat Components:</h6>

        <a class="collapse-item {{ isActive('production-materials.index') }}"
          href="{{ route('production-materials.index') }}"><i
            class="fas fa-warehouse mr-2 text-primary"></i>Inventory</a>


        <a class="collapse-item {{ isActive('production-material-requests.create') }}"
          href="{{ route('production-material-requests.create') }}"><i
            class="fas fa-plus-square mr-2 text-success"></i>Create Request</a>
        <a class="collapse-item {{ isActive('production-material-requests.index') }}"
          href="{{ route('production-material-requests.index') }}"><i class="fas fa-history mr-2"></i>Request
          History</a>


        <a class="collapse-item {{ isActive('production-material-requests.queue-list') }}"
          href="{{ route('production-material-requests.queue-list') }}"><i
            class="fas fa-list mr-2 text-warning"></i>Queue
          List</a>
      </div>
    </div>
  </li> --}}

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>


</ul>
