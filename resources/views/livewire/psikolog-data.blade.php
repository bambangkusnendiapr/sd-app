@section('title', 'Psikolog')

@section('student', 'active')

<div>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profil Psikolog <strong class="font-italic">{{ $student->nama }}</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student') }}">Siswa</a></li>
            <li class="breadcrumb-item active">Profil Psikolog</li>
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
              <a href="{{ route('student') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Back</a>
              <button wire:click.prevent="addNew" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data</button>
  
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
              </div>
  
              <div class="table-responsive-sm">
                <table class="table table-sm table-striped mt-1">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>IQ</th>
                            <th>Kemandirian</th>
                            <th>Kemampuan Bekerja</th>
                            <th>Penyesuaian Diri</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($psychologist as $key => $data)
                        <tr class="text-center">
                            <td>{{ $psychologist->firstItem() + $key }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>{{ $data->iq }}</td>
                            <td>{{ $data->kemandirian }}</td>
                            <td>{{ $data->kemampuan_bekerja }}</td>
                            <td>{{ $data->penyesuaian_diri }}</td>
                            <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                              <button wire:click.prevent="edit({{ $data->id }})" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                              <button wire:click.prevent="delete({{ $data->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </div>
                            </td>
                        </tr>
                      @empty
                        <tr>
                            <td colspan="8" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                        </tr>
                      @endforelse
                    </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="d-flex justify-content-center">
               {{ $psychologist->links() }}
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
          <h4 class="modal-title">{{ $form == 'tambah' ? 'Tambah':'Edit' }} Profil Psikolog</h4>
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
              <label for="tanggal">Tanggal</label>
              <input wire:model.defer="state.tanggal" required type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" placeholder="tanggal" autofocus>
              @error('tanggal')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="iq">IQ</label>
              <input wire:model.defer="state.iq" required type="number" class="form-control @error('iq') is-invalid @enderror" id="iq" placeholder="iq">
              @error('iq')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="kemandirian">Kemandirian</label>
              <select wire:model.defer="state.kemandirian" required class="form-control @error('kemandirian') is-invalid @enderror" id="kemandirian">
                <option value="">Pilih Kemandirian</option>
                <option value="Matang">Matang</option>
                <option value="Belum Matang">Belum Matang</option>
              </select>
              @error('kemandirian')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="kemampuanBekerja">Kemampuan Bekerja</label>
              <select wire:model.defer="state.kemampuanBekerja" required class="form-control @error('kemampuanBekerja') is-invalid @enderror" id="kemampuanBekerja">
                <option value="">Pilih</option>
                <option value="Matang">Matang</option>
                <option value="Belum Matang">Belum Matang</option>
              </select>
              @error('kemampuanBekerja')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="form-group">
              <label for="penyesuaianDiri">Penyesuaian Diri</label>
              <select wire:model.defer="state.penyesuaianDiri" required class="form-control @error('penyesuaianDiri') is-invalid @enderror" id="penyesuaianDiri">
                <option value="">Pilih</option>
                <option value="Matang">Matang</option>
                <option value="Belum Matang">Belum Matang</option>
              </select>
              @error('penyesuaianDiri')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            @if($form == 'tambah')
            <button type="submit" class="btn btn-primary">Simpan</button>
            @else
            <button type="submit" class="btn btn-warning">Edit</button>
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
          <h4 class="modal-title">Konfirmasi Data Psikolog</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-danger">
            <h5>Yakin akan hapus data ?</h5>
        </div>
        <div class="modal-footer justify-content-between bg-danger">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button wire:click.prevent="deleteData" type="button" class="btn btn-light">Lanjut Hapus</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Upload File</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('psikologImport') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" name="file" required class="custom-file-input @error('file') is-invalid @enderror" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                </div>                
              </div>
              @error('file')
              <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Upload</button>
          </div>
        </form>
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
<!-- bs-custom-file-input -->
<script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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
<script>
  $(function () {
      bsCustomFileInput.init();
  });
</script>
@endpush