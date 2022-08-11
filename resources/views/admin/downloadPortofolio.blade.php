<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="page-header">
          Portofolio Peserta Didik
        </h2>
        <h3>SD Persis Asy-Syuhada</h3>
      </div>
      <!-- /.col -->
    </div>

    <hr>

    <h4>Identitas Peserta Didik</h4>
    <!-- info row -->
    <div class="row invoice-info">
      
      <div class="col-sm-9 invoice-col">
        <table width="100%">
          <tr class="text-left">
            <td width="35%">Nama Peserta Didik</td>
            <td width="5%">:</td>
            <td>{{ $student->nama }}</td>
          </tr>
          <tr class="text-left">
            <td width="35%">No Induk</td>
            <td width="5%">:</td>
            <td>{{ $student->nis }}</td>
          </tr>
          <tr class="text-left">
            <td width="35%">Kelas</td>
            <td width="5%">:</td>
            <td>{{ $student->kelas }} - {{ $student->kls->nama }}</td>
          </tr>
          <tr class="text-left">
            <td width="35%">Tempat, Tanggal Lahir</td>
            <td width="5%">:</td>
            <td>{{ $student->tempat_lahir }}, {{ $student->tgl_lahir }}</td>
          </tr>
          <tr class="text-left">
            <td width="35%">Jenis Kelamin</td>
            <td width="5%">:</td>
            <td>{{ $student->jk }}</td>
          </tr>
          <tr class="text-left">
            <td width="35%">Alamat</td>
            <td width="5%">:</td>
            <td>{{ $student->alamat }}</td>
          </tr>
        </table>
      </div>
      <!-- /.col -->

      <div class="col-sm-3 invoice-col">
        @if ($student->gambar)
        <img class="img img-fluid" src="{{ asset('images/siswa/'.$student->gambar) }}" alt="">
        @else
        <img class="img img-fluid" src="{{ asset('images/user.jpg') }}" alt="">
        @endif
      </div>
      <!-- /.col -->

    </div>
    <!-- /.row -->

    <hr>
    
    <h4>Profil Psikologi Peserta Didik</h4>
    <div class="row invoice-info">
      
      <div class="col-12 invoice-col">
        <table width="100%" class="table table-striped table-sm">
          <tr class="text-center">
            <th>Tanggal</th>
            <th>IQ</th>
            <th>Kemandirian</th>
            <th>Kemampuan Bekerja</th>
            <th>Penyesuaian Diri</th>
          </tr>
          @foreach ($student->psychologist as $psikolog)
          <tr class="text-center">
            <td>{{ $psikolog->tanggal }}</td>
            <td>{{ $psikolog->iq }}</td>
            <td>{{ $psikolog->kemandirian }}</td>
            <td>{{ $psikolog->kemampuan_bekerja }}</td>
            <td>{{ $psikolog->penyesuaian_diri }}</td>
          </tr>
          @endforeach
        </table>
      </div>
      <!-- /.col -->

    </div>

    <hr>

    <h4>Kemampuan Peserta Didik</h4>
    <div style="margin-top: 20px">
      <h5 style="margin-bottom: 10px">1. Hafalan Surat Terakhir: <small>{{ $student->surah->nama }}</small></h5>
      <h5 style="margin-bottom: 0px">2. Surat Yang Sudah Hafal:</h5>
      <span style="margin-left: 20px">
        @foreach ($student->surats as $surat)
        <span style="color: green">{{ $surat->nama }},</span>
        @endforeach
      </span>
      <h5 style="margin-top: 10px">3. Tahsin (5 Terakhir)</h5>
      <div class="row invoice-info ml-3">
        
        <div class="col-12 invoice-col">
          <table width="100%" class="table table-striped table-sm">
            <tr class="text-center">
              <th>Tanggal</th>
              <th>Jilid</th>
              <th>Halaman</th>
              <th>Murajaah</th>
              <th>Ziyadah</th>
              <th>Nilai</th>
            </tr>
            @foreach ($student->tahsins->sortByDesc('id')->take(5) as $tahsin)
            <tr class="text-center">
              <td>{{ $tahsin->tanggal }}</td>
              <td>{{ $tahsin->jilid }}</td>
              <td>{{ $tahsin->halaman }}</td>
              <td>{{ $tahsin->murajaah }}</td>
              <td>{{ $tahsin->ziyadah }}</td>
              <td>{{ $tahsin->nilai }}</td>
            </tr>
            @endforeach
          </table>
        </div>
        <!-- /.col -->
  
      </div>
    </div>

    <hr>

    <h4>Kedisiplinan Peserta Didik</h4>
    <div class="row justify-content-center">
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon elevation-1"><i class="fas fa-pray"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Sholat Dhuha</span>
            <span class="info-box-number">
              {{ number_format($persenDhuha, 2, ',', '.') }}
              <small>%</small>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon elevation-1"><i class="fas fa-pray"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Sholat Fardhu</span>
            <span class="info-box-number">
              {{ number_format($persenFardhu, 2, ',', '.') }}
              <small>%</small>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box">
          <span class="info-box-icon elevation-1"><i class="fas fa-pray"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Shaum Sunnah</span>
            <span class="info-box-number">
              {{ number_format($persenShaum, 2, ',', '.') }}
              <small>%</small>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>