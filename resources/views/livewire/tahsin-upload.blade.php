@section('title', 'Tahsin')

@section('tahsinUpload', 'active')

<div>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Tahsin</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Data Tahsin</li>
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
              <a href="{{ route('tahsinExport') }}" class="btn btn-success"><i class="fas fa-file-download"></i> Download Template</a>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default"><i class="fas fa-file-upload"></i> Upload File</button>
  
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
                            <input wire:model="search" type="text" class="form-control" placeholder="Cari Nama...">
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
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Jilid</th>
                            <th>Halaman</th>
                            <th>Murajaah</th>
                            <th>Ziyadah</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($tahsin as $key => $data)
                        <tr class="text-center">
                            <td>{{ $tahsin->firstItem() + $key }}</td>
                            <td>{{ $data->tanggal }}</td>
                            <td>{{ $data->student->nama }}</td>
                            <td>{{ $data->jilid }}</td>
                            <td>{{ $data->halaman }}</td>
                            <td>{{ $data->murajaah }}</td>
                            <td>{{ $data->ziyadah }}</td>
                            <td>{{ $data->nilai }}</td>
                            <td>{{ $data->ket }}</td>
                        </tr>
                      @empty
                        <tr>
                            <td colspan="9" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                        </tr>
                      @endforelse
                    </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="d-flex justify-content-center">
               {{ $tahsin->links() }}
              </div>
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title">Upload File</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('tahsinImport') }}" method="post" enctype="multipart/form-data">
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
      bsCustomFileInput.init();
  });
</script>
@endpush