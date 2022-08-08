@section('title', 'Role')

@section('menu-master', 'menu-open')
@section('master', 'active')
@section('roles', 'active')

<x-admin-layout>
  
  <div>
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="{{ route('roles') }}">Role</a></li>
              <li class="breadcrumb-item active">Create Role</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
    
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <a href="{{ route('roles') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Back</a>
    
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <form action="{{ route('role.store') }}" method="POST">
              @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" required autofocus placeholder="Name" value="{{ old('name') }}">
                        @error('name')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="display">Display Name</label>
                        <input name="display" type="text" class="form-control @error('display') is-invalid @enderror" id="display" required placeholder="Display Name" value="{{ old('display') }}">
                        @error('display')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="description">Description</label>
                        <input name="description" type="text" class="form-control @error('description') is-invalid @enderror" id="description" required placeholder="Description" value="{{ old('description') }}">
                        @error('description')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <hr>

                  <div class="row">
                    @foreach ($menus as $menu)
                    <div class="col-md-4" id="accordion">
                      <div class="card card-primary card-outline">
                        <a class="d-block w-100" data-toggle="collapse" href="#collapse{{ $menu->id }}">
                            <div class="card-header">
                                <h4 class="card-title w-100 text-center">
                                  {{ $menu->name }}
                                </h4>
                            </div>
                        </a>
                        <div id="collapse{{ $menu->id }}" class="collapse" data-parent="#accordion">
                          <div class="card-body">
                            @foreach ($menu->permissions as $permission)
                            <div class="form-check d-inline">
                                &nbsp;<input
                                    class="form-check-input"
                                    type="checkbox" id=""
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                >
                                <label class="form-check-label" for="">{{ $permission->display_name }}</label>
                            </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i> Save</button>
                  </div>
                </div>
                <!-- /.card-footer-->
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
  
  </div>

</x-admin-layout>