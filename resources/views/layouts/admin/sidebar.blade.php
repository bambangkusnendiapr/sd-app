<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
      <img src="{{ asset('images/logo.png') }}" alt="SD Persis Asy-Syuhada Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SD Asy-Syuhada</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @role('siswa')
          @foreach (Auth::user()->students as $student)
          @if ($student->gambar)
          <img src="{{ asset('images/siswa/'.$student->gambar) }}" class="img-circle elevation-2" alt="User Image">
          @else
          <img src="{{ asset('images/user.jpg') }}" class="img-circle elevation-2" alt="User Image">
          @endif          
          @endforeach
          @endrole
        @role('developer|admin')
          <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        @endrole
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
          @role('developer|admin')
          <li class="nav-item">
            <a href="{{ route('student') }}" class="nav-link @yield('student')">
                <i class="nav-icon fas fa-child"></i>
                <p>
                Siswa
                </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('psikolog') }}" class="nav-link @yield('psikolog')">
                <i class="nav-icon fas fa-clipboard-check"></i>
                <p>
                Data Psikolog
                </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('tahsinUpload') }}" class="nav-link @yield('tahsinUpload')">
                <i class="nav-icon fas fa-book-open"></i>
                <p>
                Data Tahsin
                </p>
            </a>
          </li>
          <li class="nav-item @yield('menu-kedisiplinan')">
            <a href="#" class="nav-link @yield('kedisiplinan')">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                Kedisiplinan
                <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('dhuha') }}" class="nav-link @yield('dhuha')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sholat Dhuha</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('fardhu') }}" class="nav-link @yield('fardhu')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sholat Fardhu</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('shaum') }}" class="nav-link @yield('shaum')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Shaum Sunnah</p>
                  </a>
                </li>
            </ul>
          </li>
          @endrole
          <li class="nav-item">
            <a href="{{ route('portofolio') }}" class="nav-link @yield('portofolio')">
                <i class="nav-icon fas fa-address-card"></i>
                <p>
                Portofolio
                </p>
            </a>
          </li>
          @role('developer|admin')
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
                @role('developer')
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
                @endrole
                <li class="nav-item">
                  <a href="{{ route('kelas') }}" class="nav-link @yield('kelas')">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Kelas</p>
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