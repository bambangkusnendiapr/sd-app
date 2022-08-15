@section('title', 'Profile')

<div>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                @role('developer|admin')
                <img class="profile-user-img img-fluid img-circle"
                      src="{{ asset('admin/dist/img/user2-160x160.jpg') }}"
                      alt="User profile picture">
                @endrole
                @role('siswa')
                <img class="profile-user-img img-fluid img-circle"
                      src="{{ asset('images/user.jpg') }}"
                      alt="User profile picture">
                @endrole
              </div>

              <h3 class="profile-username text-center">{{ $nama }}</h3>

              @foreach(Auth::user()->roles as $role)
              <p class="text-muted text-center">{{ $role->display_name }}</p>
              @endforeach
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Profile</a></li>
                <li class="nav-item"><a wire:click.prevent="formPassword" class="nav-link" href="#">Ganti Password</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <form wire:submit.prevent="updateProfile" class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input wire:model.defer="state.nama" type="text" class="form-control  @error('nama') is-invalid @enderror" id="inputName">
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input wire:model.defer="state.email" type="email" class="form-control  @error('email') is-invalid @enderror" id="inputEmail">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Username</label>
                      <div class="col-sm-10">
                        <input wire:model.defer="state.username" type="text" class="form-control  @error('username') is-invalid @enderror" id="inputEmail">
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Simpan Profile</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <div class="modal fade" id="form" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Form Ganti Password</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form wire:submit.prevent="updatePassword">
          <div class="modal-body">
            <div class="form-group">
              <label for="password" class="col-form-label">Password Baru</label>
              <input wire:model.defer="state.password" required type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password Baru">
              @error('password')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="password-confirm" class="col-form-label">Ulangi Password Baru</label>
              <input wire:model.defer="state.password_confirmation" required type="password" class="form-control" id="password-confirm" placeholder="Ulangi Password Baru">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Simpan Password Baru</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

</div>

@push('style')
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('script')
<!-- SweetAlert2 -->
<script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Sweet alert real rashid -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script>
  $(function () {

    window.addEventListener('update-profile', event => {

        Swal.fire({
            "title":"Sukses!",
            "text":"Profile Berhasil Di-Update",
            "position":"middle-center",
            "timer":2000,
            "width":"32rem",
            "heightAuto":true,
            "padding":"1.25rem",
            "showConfirmButton":false,
            "showCloseButton":false,
            "icon":"success"
        });

    });

    window.addEventListener('show-form', event => {
        $('#form').modal('show');
    });

    window.addEventListener('update-password', event => {
      $('#form').modal('hide');

      Swal.fire({
          "title":"Sukses!",
          "text":"Password Berhasil Di-Update",
          "position":"middle-center",
          "timer":2000,
          "width":"32rem",
          "heightAuto":true,
          "padding":"1.25rem",
          "showConfirmButton":false,
          "showCloseButton":false,
          "icon":"success"
      });

    });

  });
</script>

@endpush