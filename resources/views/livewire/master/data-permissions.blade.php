@section('title', 'Permission')

@section('menu-master', 'menu-open')
@section('master', 'active')
@section('permissions', 'active')

<div>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Permission</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Permission</li>
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
              <button wire:click.prevent="addNew" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Add Permission</button>
  
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <select wire:model="paginate" class="form-control form-control-xl">
                            <option value="10">10 data per page</option>
                            <option value="15">15 data per page</option>
                            <option value="20">20 data per page</option>
                            <option value="30">30 data per page</option>
                            <option value="50">50 data per page</option>
                        </select>
                    </div>
                </div>
  
                <div class="col-md-4 offset-md-4">
                    <div class="form-group">
                        <div class="input-group input-group-xl">
                            <input wire:model="search" type="text" class="form-control" placeholder="Search display name...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
  
              <div class="table-responsive-sm">
                <table class="table table-sm table-striped mt-1">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Menu</th>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($permissions as $key => $data)
                        <tr class="text-center">
                            <td>{{ $permissions->firstItem() + $key }}</td>
                            @foreach($data->menus as $menu)
                            <td>{{ $menu->name }}</td>
                            @endforeach
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->display_name }}</td>
                            <td>{{ $data->description }}</td>
                            <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                              <button wire:click.prevent="edit({{ $data->id }})" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                              <button wire:click.prevent="delete({{ $data->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </div>
                            </td>
                        </tr>
                      @empty
                        <tr>
                            <td colspan="4" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                        </tr>
                      @endforelse
                    </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="d-flex justify-content-center">
               {{ $permissions->links() }}
              </div>
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  
  <div class="modal fade" id="form" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header {{ $form == 'tambah' ? 'bg-primary':'bg-warning' }}">
          <h4 class="modal-title">{{ $form == 'tambah' ? 'Add':'Edit' }} Permission</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @if($form == 'tambah')
        <form wire:submit.prevent="createData">
        @else
        <form wire:submit.prevent="updateData">
        @endif
          <div class="modal-body">
            <div class="form-group">
              <label for="menu">Menu</label>
              <select wire:model.defer="state.menu" class="form-control @error('menu') is-invalid @enderror" required id="menu">
                <option value="">Choose Menu</option>
                @foreach ($menus as $menu)
                  <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                @endforeach
              </select>
              @error('menu')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="name">Name</label>
              <input wire:model.defer="state.name" required type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="display">Display Name</label>
              <input wire:model.defer="state.display" required type="text" class="form-control @error('display') is-invalid @enderror" id="display" placeholder="Display Name" autofocus>
              @error('display')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="desc">Description</label>
              <textarea wire:model.defer="state.desc" required id="desc" class="form-control @error('desc') is-invalid @enderror" placeholder="Keterangan..."></textarea>
              @error('desc')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            @if($form == 'tambah')
            <button type="submit" class="btn btn-primary">Save</button>
            @else
            <button type="submit" class="btn btn-warning">Update</button>
            @endif
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="form-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Confirm Delete Permission</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-danger">
            <h5>Are you sure delete the permission ?</h5>
        </div>
        <div class="modal-footer justify-content-between bg-danger">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button wire:click.prevent="deleteData" type="button" class="btn btn-light">Delete</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

</div>

@push('style')
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@push('script')
<!-- SweetAlert2 -->
<script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Sweet alert real rashid -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script>
  $(function () {

    window.addEventListener('show-form', event => {
        $('#form').modal('show');
    });

    window.addEventListener('hide-form', event => {
        $('#form').modal('hide');

        Swal.fire({
            "title":"Sukses!",
            "text":"Data Berhasil Ditambahkan",
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

    window.addEventListener('hide-form-edit', event => {
        $('#form').modal('hide');

        Swal.fire({
            "title":"Sukses!",
            "text":"Data Berhasil Diedit",
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

    window.addEventListener('show-form-delete', event => {
        $('#form-delete').modal('show');
    });

    window.addEventListener('hide-form-delete', event => {
        $('#form-delete').modal('hide');

        Swal.fire({
            "title":"Sukses!",
            "text":"Data Berhasil Dihapus",
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