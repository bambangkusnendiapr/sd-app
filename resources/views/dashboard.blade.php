@section('title', 'Dashboard')

@section('dashboard', 'active')

<x-admin-layout>
  
  <div>
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
    
      <div class="container-fluid">
        <div class="row">
          <div class="col-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $siswa }}</h3>

                <p>Siswa</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-users"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $laki }}</h3>

                <p>Siswa Laki-laki</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-male"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-4">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $perempuan }}</h3>

                <p>Siswa Perempuan</p>
              </div>
              <div class="icon">
                <i class="nav-icon fas fa-female"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div>
    </section>
  
  </div>

</x-admin-layout>
