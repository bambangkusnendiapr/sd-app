@section('title', 'Siswa')

@section('student', 'active')

<div>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Siswa</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Siswa</li>
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
              <a href="{{ route('student.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Siswa</a>
              <a href="{{ route('studentExport') }}" class="btn btn-success"><i class="fas fa-file-download"></i> Download Template</a>
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
                <div class="col-md-2">
                  <div class="form-group">
                      <select wire:model="kelas" class="form-control form-control-xl">
                          <option value="Semua">Semua Kelas</option>
                          <option value="1">Kelas 1</option>
                          <option value="2">Kelas 2</option>
                          <option value="3">Kelas 3</option>
                          <option value="4">Kelas 4</option>
                          <option value="5">Kelas 5</option>
                          <option value="6">Kelas 6</option>
                      </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                      <select wire:model="kelasTipe" class="form-control form-control-xl">
                          <option value="Semua">Semua Tipe Kelas</option>
                          @foreach ($kelasData as $kls)
                          <option value="{{ $kls->id }}">{{ $kls->nama }}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
                <div class="col-md-3">
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
  
                <div class="col-md-4">
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
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Data</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse ($students as $key => $data)
                        <tr class="text-center">
                            <td>{{ $students->firstItem() + $key }}</td>
                            <td>{{ $data->id }}</td>
                            <td class="text-left">{{ $data->nama }}</td>
                            <td>{{ $data->kelas }} - {{ $data->kls->nama }}</td>
                            <td>
                              <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('psikolog.data', $data->id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-clipboard-check"></i> Psikolog</a>
                                <a href="{{ route('tahsin', $data->id) }}" class="btn btn-success btn-sm"><i class="fas fa-book-open"></i> Tahsin & Tahfizh</a>
                              </div>
                            </td>
                            <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                              <button wire:click.prevent="detail({{ $data->id }})" class="btn btn-info btn-sm"><i class="fas fa-info"></i></button>
                              <a href="{{ route('student.edit', $data->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                              <button wire:click.prevent="delete({{ $data->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </div>
                            </td>
                        </tr>
                      @empty
                        <tr>
                            <td colspan="6" class="text-center font-italic text-danger"><h5>-- Data Tidak Ditemukan --</h5></td>
                        </tr>
                      @endforelse
                    </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <div class="d-flex justify-content-center">
               {{ $students->links() }}
              </div>
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="form-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Konfirmasi Hapus Siswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-danger">
            <h5>Yakin akan hapus data siswa ?</h5>
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
        <form action="{{ route('studentsImport') }}" method="post" enctype="multipart/form-data">
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

  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title">IDENTITAS PESERTA DIDIK</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">
            <table width="100%" class="table table-striped table-sm">
              <tr>
                <td width="5%">1.</td>
                <td width="30%">Nama Peserta Didik</td>
                <td width="5%">:</td>
                <td>{{ $nama }}</td>
              </tr>
              <tr>
                <td width="5%">2.</td>
                <td width="30%">Nomor Induk</td>
                <td width="5%">:</td>
                <td>{{ $nis }}</td>
              </tr>
              <tr>
                <td width="5%">3.</td>
                <td width="30%">Tempat, Tanggal Lahir</td>
                <td width="5%">:</td>
                <td>{{ $tempat }}, {{ $tgl }}</td>
              </tr>
              <tr>
                <td width="5%">4.</td>
                <td width="30%">Jenis Kelamin</td>
                <td width="5%">:</td>
                <td>{{ $jk }}</td>
              </tr>
              <tr>
                <td width="5%">5.</td>
                <td width="30%">Agama</td>
                <td width="5%">:</td>
                <td>{{ $agama }}</td>
              </tr>
              <tr>
                <td width="5%">6.</td>
                <td width="30%">Pendidikan Sebelumnya</td>
                <td width="5%">:</td>
                <td>{{ $sekolah }}</td>
              </tr>
              <tr>
                <td width="5%">7.</td>
                <td width="30%">Alamat Peserta Didik</td>
                <td width="5%">:</td>
                <td>{{ $alamat }}</td>
              </tr>
              <tr>
                <td width="5%">8.</td>
                <td width="30%">Nama Orang Tua</td>
                <td width="5%">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">a. Ayah</td>
                <td width="5%">:</td>
                <td>{{ $namaAyah }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">b. Ibu</td>
                <td width="5%">:</td>
                <td>{{ $namaIbu }}</td>
              </tr>
              <tr>
                <td width="5%">9.</td>
                <td width="30%">Pekerjaan Orang Tua</td>
                <td width="5%">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">a. Ayah</td>
                <td width="5%">:</td>
                <td>{{ $kerjaAyah }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">b. Ibu</td>
                <td width="5%">:</td>
                <td>{{ $kerjaIbu }}</td>
              </tr>
              <tr>
                <td width="5%">10.</td>
                <td width="30%">Alamat Orang Tua</td>
                <td width="5%">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">Jalan</td>
                <td width="5%">:</td>
                <td>{{ $jalanOrtu }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">Kelurahan / Desa</td>
                <td width="5%">:</td>
                <td>{{ $kel }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">Kecamatan</td>
                <td width="5%">:</td>
                <td>{{ $kec }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">Kota / Kabupaten</td>
                <td width="5%">:</td>
                <td>{{ $kota }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">Propinsi</td>
                <td width="5%">:</td>
                <td>{{ $prov }}</td>
              </tr>
              <tr>
                <td width="5%">11.</td>
                <td width="30%">Wali Peserta Didik</td>
                <td width="5%">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">a. Nama</td>
                <td width="5%">:</td>
                <td>{{ $namaWali }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">b. Pekerjaan</td>
                <td width="5%">:</td>
                <td>{{ $kerjaWali }}</td>
              </tr>
              <tr>
                <td width="5%">&nbsp;</td>
                <td width="30%">c. Alamat</td>
                <td width="5%">:</td>
                <td>{{ $alamatWali }}</td>
              </tr>
            </table>
            @if ($gambar)
            <img src="{{ asset('images/siswa/'.$gambar) }}" alt="Foto Siswa" width="200px" class="img img-fluid">
            @else
            <img src="{{ asset('images/user.jpg') }}" alt="Foto Siswa" width="200px" class="img img-fluid">
            @endif
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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
<!-- bs-custom-file-input -->
<script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
  $(function () {

    window.addEventListener('show-detail', event => {
        $('#modal-detail').modal('show');
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