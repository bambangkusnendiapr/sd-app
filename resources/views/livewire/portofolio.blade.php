@section('title', 'Portofolio')

@section('portofolio', 'active')

<div>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Portofolio</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Portofolio</li>
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
          <div class="card card-outline card-primary">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <select wire:model="siswaId" class="form-control" required>
                      <option value="Semua">Pilih Siswa</option>
                      @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card card-outline card-primary">
            <div class="card-body text-center">
              <h2>Portofolio Peserta Didik</h2>
              <h3>SD Persis Asy-Syuhada</h3>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-header bg-primary">
              <h3 class="card-title">Identitas Peserta Didik</h3>
            </div>
            @if ($siswa != 'kosong')
            <div class="card-body text-center">
              <div class="row">
                <div class="col-md-3">
                  @if ($gambar)
                  <img src="{{ asset('images/siswa/'.$gambar) }}" alt="Foto Siswa" class="img img-fluid" height="10px">
                  @else
                  <img src="{{ asset('images/user.jpg') }}" alt="Foto Siswa" class="img img-fluid" height="10px">
                  @endif
                </div>
                <div class="col-md-9">
                <div class="table-responsive">
                  <table class="table table-striped table-sm">
                    <tr class="text-left">
                      <td width="35%">Nama Peserta Didik</td>
                      <td width="5%">:</td>
                      <td>{{ $nama }}</td>
                    </tr>
                    <tr class="text-left">
                      <td width="35%">No Induk</td>
                      <td width="5%">:</td>
                      <td>{{ $nis }}</td>
                    </tr>
                    <tr class="text-left">
                      <td width="35%">Kelas</td>
                      <td width="5%">:</td>
                      <td>{{ $kelas }} - {{ $kelasTipe }}</td>
                    </tr>
                    <tr class="text-left">
                      <td width="35%">Tempat, Tanggal Lahir</td>
                      <td width="5%">:</td>
                      <td>{{ $tempatLahir }}, {{ $tglLahir }}</td>
                    </tr>
                    <tr class="text-left">
                      <td width="35%">Jenis Kelamin</td>
                      <td width="5%">:</td>
                      <td>{{ $jk }}</td>
                    </tr>
                    <tr class="text-left">
                      <td width="35%">Alamat</td>
                      <td width="5%">:</td>
                      <td>{{ $alamat }}</td>
                    </tr>
                  </table>
                </div>
                </div>
              </div>
            </div>
            @endif
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-header bg-primary">
              <h3 class="card-title">Profil Psikologi</h3>
            </div>
            @if ($siswa != 'kosong')
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <tr class="text-center">
                    <th>Tanggal</th>
                    <th>IQ</th>
                    <th>Kemandirian</th>
                    <th>Kemampuan Bekerja</th>
                    <th>Penyesuaian Diri</th>
                  </tr>
                    @foreach ($siswa->psychologist->where('is_deleted', false) as $data)
                      <tr class="text-center">
                        <td>{{ $data->tanggal }}</td>
                        <td>{{ $data->iq }}</td>
                        <td>{{ $data->kemandirian }}</td>
                        <td>{{ $data->kemampuan_bekerja }}</td>
                        <td>{{ $data->penyesuaian_diri }}</td>
                      </tr>                  
                    @endforeach
                </table>
              </div>
            </div>
            @endif
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-header bg-primary">
              <h3 class="card-title">Kemampuan Peserta Didik</h3>
            </div>
            @if ($siswa != 'kosong')
            <div class="card-body">
              <div>
                <h5><strong>1. Hafalan Surat Terakhir: </strong> {{ $siswa->surah->nama }} </h5>
              </div>
              <div>
                <h5><strong>2. Surat Yang Sudah Dihafal</strong></h5>
                <div class="mt-n2 ml-4">
                  @foreach ($siswa->surats as $surat)
                  <span class="badge badge-success">{{ $surat->nama }}</span>
                  @endforeach
                </div>
              </div>
              <div class="mt-3">
                <h5><strong>3. Tahsin</strong></h5>
                <div class="ml-4">
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-sm">
                          <tr class="text-center">
                            <th>Tanggal</th>
                            <th>Jilid</th>
                            <th>Halaman</th>
                            <th>Murajaah</th>
                            <th>Ziyadah</th>
                            <th>Nilai</th>
                          </tr>
                          @if ($siswa != 'kosong')
                            @foreach ($siswa->tahsins->where('is_deleted', false) as $data)
                              <tr class="text-center">
                                <td>{{ $data->tanggal }}</td>
                                <td>{{ $data->jilid }}</td>
                                <td>{{ $data->halaman }}</td>
                                <td>{{ $data->murajaah }}</td>
                                <td>{{ $data->ziyadah }}</td>
                                <td>{{ $data->nilai }}</td>
                              </tr>                  
                            @endforeach
                          @endif
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>

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
<!-- bs-custom-file-input -->
<script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
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
<script>
  $(function () {
    $('.select2').select2()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
</script>
@endpush