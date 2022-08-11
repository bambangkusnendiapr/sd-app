@section('title', 'Edit Siswa')

@section('student', 'active')

<x-admin-layout>
  
  <div>
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="{{ route('student') }}" class="btn btn-dark mt-n2"><i class="fas fa-arrow-left"></i> Back</a>
            <h1 class="d-inline">Form Edit Siswa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="{{ route('student') }}">Siswa</a></li>
              <li class="breadcrumb-item active">Form Edit Siswa</li>
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
            <form action="{{ route('student.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
              @method('put')
            @csrf
              <!-- Default box -->
              <!-- Akun -->
              <div class="card">
                <div class="card-header bg-warning">
                  <h3 class="card-title">Akun</h3>
                </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="nama">Nama</label>
                          <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" required autofocus placeholder="Nama" value="{{ $siswa->nama }}">
                          @error('nama')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username" required placeholder="Username" value="{{ $siswa->user->username }}">
                          @error('username')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" required placeholder="Email" value="{{ $siswa->user->email }}">
                          @error('email')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="password">Password (Kosongkan jika tidak ganti paswword)</label>
                          <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                          @error('password')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="password-confirm">Ulangi Password</label>
                          <input name="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" id="password-confirm" placeholder="Ulangi Password">
                          @error('password')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- Data Siswa -->
              <div class="card">
                <div class="card-header bg-warning">
                  <h3 class="card-title">Data Siswa</h3>
                </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="tanggalMasuk">Tanggal Masuk</label>
                          <input name="tanggalMasuk" type="date" class="form-control @error('tanggalMasuk') is-invalid @enderror" id="tanggalMasuk" required placeholder="tanggalMasuk" value="{{ $siswa->tanggal_masuk }}">
                          @error('tanggalMasuk')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="kelas">Kelas</label>
                          <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror" required>
                            <option value="">Pilih Kelas</option>
                            <option value="1" {{ $siswa->kelas == 1 ? 'selected':'' }}>1</option>
                            <option value="2" {{ $siswa->kelas == 2 ? 'selected':'' }}>2</option>
                            <option value="3" {{ $siswa->kelas == 3 ? 'selected':'' }}>3</option>
                            <option value="4" {{ $siswa->kelas == 4 ? 'selected':'' }}>4</option>
                            <option value="5" {{ $siswa->kelas == 5 ? 'selected':'' }}>5</option>
                            <option value="6" {{ $siswa->kelas == 6 ? 'selected':'' }}>6</option>
                          </select>
                          @error('kelas')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="kelasTipe">Kelas Tipe</label>
                          <select name="kelasTipe" id="kelasTipe" class="form-control @error('kelasTipe') is-invalid @enderror" required>
                            <option value="">Pilih Kelas Tipe</option>
                            @foreach ($kelas as $kls)
                            <option value="{{ $kls->id }}" {{ $siswa->kelas_id == $kls->id ? 'selected':'' }}>{{ $kls->nama }}</option>
                            @endforeach
                          </select>
                          @error('kelasTipe')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="noInduk">Nomor Induk</label>
                          <input name="noInduk" type="text" class="form-control @error('noInduk') is-invalid @enderror" id="noInduk" required placeholder="Nomor Induk" value="{{ $siswa->nis }}">
                          @error('noInduk')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="tempatLahir">Tempat Lahir</label>
                          <input name="tempatLahir" type="text" class="form-control @error('tempatLahir') is-invalid @enderror" id="tempatLahir" required placeholder="tempat Lahir" value="{{ $siswa->tempat_lahir }}">
                          @error('tempatLahir')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="tglLahir">Tanggal Lahir</label>
                          <input name="tglLahir" type="date" class="form-control @error('tglLahir') is-invalid @enderror" id="tglLahir" required placeholder="Tanggal Lahir" value="{{ $siswa->tgl_lahir }}">
                          @error('tglLahir')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="jk">Jenis Kelamin</label>
                          <select name="jk" id="jk" class="form-control @error('jk') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ $siswa->jk == 'Laki-laki' ? 'selected':'' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $siswa->jk == 'Laki-laki' ? '':'selected' }}>Perempuan</option>
                          </select>
                          @error('jk')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="agama">Agama</label>
                          <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ $siswa->agama == 'Islam' ? 'selected':'' }}>Islam</option>
                            <option value="Protestan" {{ $siswa->agama == 'Protestan' ? 'selected':'' }}>Protestan</option>
                            <option value="Katolik" {{ $siswa->agama == 'Katolik' ? 'selected':'' }}>Katolik</option>
                            <option value="Hindu" {{ $siswa->agama == 'Hindu' ? 'selected':'' }}>Hindu</option>
                            <option value="Buddha" {{ $siswa->agama == 'Buddha' ? 'selected':'' }}>Buddha</option>
                            <option value="Konghucu" {{ $siswa->agama == 'Konghucu' ? 'selected':'' }}>Konghucu</option>
                          </select>
                          @error('agama')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="pendidikan">Pendidikan Sebelumnya</label>
                          <input name="pendidikan" type="text" class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" required placeholder="Pendidikan Sebelumnya" value="{{ $siswa->sekolah_asal }}">
                          @error('pendidikan')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="hafalan">Hafalan Surat Awal</label>
                          <input name="hafalan" type="text" class="form-control @error('hafalan') is-invalid @enderror" id="hafalan" required placeholder="Hafalan Surat Awal" value="{{ $siswa->surat_awal }}">
                          @error('hafalan')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" required placeholder="Alamat">{{ $siswa->alamat }}</textarea>
                          @error('alamat')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group"> 
                          <label><strong>Foto</strong></label>@error('filefoto') <span class="text-danger font-italic">{{ $message }}</span>@enderror
                          <div class="custom-file">
                              <input type="file" name="filefoto" class="custom-file-input @error('filefoto') is-invalid @enderror" id="filefoto">
                              <label class="custom-file-label" for="filefoto">Pilih Gambar</label>
                              <div class="text-default">
                                Max: 2mb
                              </div>
                          </div>
                        </div>
                        <div class="form-group">
                          @if($siswa->gambar)
                          <img id="img" src="{{ asset('images/siswa/'.$siswa->gambar)}}" width="100px" height="100px"/>
                          @else
                          <img id="img" src="{{ asset('images/user.jpg')}}" width="100px" height="100px"/>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>

              <!-- Data Orang Tua -->
              <div class="card">
                <div class="card-header bg-warning">
                  <h3 class="card-title">Data Orang Tua</h3>
                </div>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="namaAyah">Nama Ayah</label>
                          <input name="namaAyah" type="text" class="form-control @error('namaAyah') is-invalid @enderror" id="namaAyah" required placeholder="Nama Ayah" value="{{ $siswa->nama_ayah }}">
                          @error('namaAyah')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="namaIbu">Nama Ibu</label>
                          <input name="namaIbu" type="text" class="form-control @error('namaIbu') is-invalid @enderror" id="namaIbu" required placeholder="Nama Ibu" value="{{ $siswa->nama_ibu }}">
                          @error('namaIbu')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kerjaAyah">Kerja Ayah</label>
                          <input name="kerjaAyah" type="text" class="form-control @error('kerjaAyah') is-invalid @enderror" id="kerjaAyah" required placeholder="Kerja Ayah" value="{{ $siswa->kerja_ayah }}">
                          @error('kerjaAyah')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kerjaIbu">Kerja Ibu</label>
                          <input name="kerjaIbu" type="text" class="form-control @error('kerjaIbu') is-invalid @enderror" id="kerjaIbu" required placeholder="Kerja Ibu" value="{{ $siswa->kerja_ibu }}">
                          @error('kerjaIbu')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="jalan">Alamat Jalan</label>
                          <input name="jalan" type="text" class="form-control @error('jalan') is-invalid @enderror" id="jalan" required placeholder="Alamat Jalan" value="{{ $siswa->jalan_ortu }}">
                          @error('jalan')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kel">Desa / Kelurahan</label>
                          <input name="kel" type="text" class="form-control @error('kel') is-invalid @enderror" id="kel" required placeholder="Desa / Kelurahan" value="{{ $siswa->kel_ortu }}">
                          @error('kel')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kec">Kecamatan</label>
                          <input name="kec" type="text" class="form-control @error('kec') is-invalid @enderror" id="kec" required placeholder="Kecamatan" value="{{ $siswa->kec_ortu }}">
                          @error('kec')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kota">Kota</label>
                          <input name="kota" type="text" class="form-control @error('kota') is-invalid @enderror" id="kota" required placeholder="Kota" value="{{ $siswa->kota_ortu }}">
                          @error('kota')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="prov">Propinsi</label>
                          <input name="prov" type="text" class="form-control @error('prov') is-invalid @enderror" id="prov" required placeholder="Propinsi" value="{{ $siswa->prov_ortu }}">
                          @error('prov')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>

              <!-- Data Wali -->
              <div class="card">
                <div class="card-header bg-warning">
                  <h3 class="card-title">Data Wali</h3>
                </div>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="namaWali">Nama Wali</label>
                          <input name="namaWali" type="text" class="form-control @error('namaWali') is-invalid @enderror" id="namaWali" placeholder="Nama Wali" value="{{ $siswa->nama_wali }}">
                          @error('namaWali')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="kerjaWali">Kerja Wali</label>
                          <input name="kerjaWali" type="text" class="form-control @error('kerjaWali') is-invalid @enderror" id="kerjaWali" placeholder="Kerja Wali" value="{{ $siswa->kerja_wali }}">
                          @error('kerjaWali')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <label for="alamatWali">Alamat Wali</label>
                          <textarea name="alamatWali" class="form-control @error('alamatWali') is-invalid @enderror" id="alamatWali" placeholder="Alamat Wali">{{ $siswa->alamat_wali }}</textarea>
                          @error('alamatWali')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
              </div>

              <div class="card">
                <div class="card-body">
                  <button type="submit" class="btn btn-warning w-100"><i class="fas fa-paper-plane"></i> Edit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  
  </div>

  @push('script')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
      $(function () {
        bsCustomFileInput.init();
        $('#filefoto').change(function(){
          var input = this;
          var url = $(this).val();
          var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
          if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
          {
              var reader = new FileReader();
              reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
              }
            reader.readAsDataURL(input.files[0]);
          }
        })
      });
    </script>
    <script>
  @endpush

</x-admin-layout>