<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
      <img src="https://laravel.com/img/logomark.min.svg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Template</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
          <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
          <a href="{{ route('profile') }}" class="d-block">{{ Auth::user()->name }}
            @foreach(Auth::user()->roles as $role)
            <span class="badge badge-success">{{ $role->display_name }}</span>
            @endforeach
          </a>
      </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link @yield('dashboard')">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                Dashboard
                </p>
            </a>
          </li>
          @role('admin')
          <li class="nav-item @yield('menu-master')">
          <a href="#" class="nav-link @yield('master')">
              <i class="nav-icon fas fa-copy"></i>
              <p>
              Master Data
              <i class="fas fa-angle-left right"></i>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users') }}" class="nav-link @yield('users')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('roles') }}" class="nav-link @yield('roles')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Role</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('permissions') }}" class="nav-link @yield('permissions')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Permission</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('menus') }}" class="nav-link @yield('menus')">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Menu</p>
                </a>
              </li>
          </ul>
          </li>
          @endrole
          <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
              Logout
              </p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
          </li>
      </ul>
      </nav>
      <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>