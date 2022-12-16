@section('title', 'Edit Data Sholat Fardhu')

@section('menu-kedisiplinan', 'menu-open')
@section('kedisiplinan', 'active')
@section('fardhu', 'active')

<x-admin-layout>
  
  <div>
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <a href="{{ route('fardhu') }}" class="btn btn-dark mt-n2"><i class="fas fa-arrow-left"></i> Back</a>
            <h1 class="d-inline">Edit Data Sholat Fardhu</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item"><a href="{{ route('fardhu') }}">Data Sholat Fardhu</a></li>
              <li class="breadcrumb-item active">Edit Data Sholat Fardhu</li>
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
            <form action="{{ route('fardhu.update', $fardhu->id) }}" method="POST">
            @method('put')
            @csrf
              <!-- Default box -->
              <!-- Akun -->
              <div class="card">
                <div class="card-header bg-warning">
                  <h3 class="card-title">Data Sholat Fardhu</h3>
                </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="tanggal">Tanggal</label>
                          <input name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" required value="{{ $fardhu->tanggal }}">
                          @error('tanggal')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="sholat">Sholat</label>
                          <select name="sholat" id="sholat" class="form-control @error('sholat') is-invalid @enderror" required>
                            <option value="">Pilih Sholat</option>
                            <option value="Shubuh" {{ $fardhu->sholat == 'Shubuh' ? 'selected':'' }}>Shubuh</option>
                            <option value="Dzuhur" {{ $fardhu->sholat == 'Dzuhur' ? 'selected':'' }}>Dzuhur</option>
                            <option value="Ashar" {{ $fardhu->sholat == 'Ashar' ? 'selected':'' }}>Ashar</option>
                            <option value="Maghrib" {{ $fardhu->sholat == 'Maghrib' ? 'selected':'' }}>Maghrib</option>
                            <option value="Isya" {{ $fardhu->sholat == 'Isya' ? 'selected':'' }}>Isya</option>
                          </select>
                          @error('sholat')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="ket">Keterangan</label>
                          <input name="ket" type="text" class="form-control @error('ket') is-invalid @enderror" id="ket" placeholder="Keterangan" value="{{ $fardhu->ket }}">
                          @error('ket')
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

              <!-- Kelas  -->
							@foreach ($kelas as $kls)
							<div id="accordion">
								<div class="card card-warning">
									<div class="card-header">
										<h3 class="card-title w-100">
											<a class="d-block w-100" data-toggle="collapse" href="#collapse{{ $kls->kelas }}">
												Kelas {{ $kls->kelas }}
											</a>
										</h3>
									</div>
									<div id="collapse{{ $kls->kelas }}" class="collapse {{ $kls->kelas == 1 ? 'show':'' }}" data-parent="#accordion">
										<div class="card-body">
											<div class="row">
												@foreach($students->where('kelas', $kls->kelas) as $student)
												<div class="col-md-3">
													<div class="form-check">
														<input
                              type="checkbox" 
                              name="siswa[]" 
                              class="form-check-input" 
                              id="exampleCheck1" 
                              value="{{ $student->id }}"
                              @php $salatView = $salat->where('student_id', $student->id)->first() @endphp
                              {{ (in_array($student->id, $fardhuStudents) && ($salatView->salat == 1)) ? 'checked="checked"' : '' }}
                              >
														<label class="form-check-label" for="exampleCheck1">{{ $student->nama }}</label>
													</div>
												</div>
												@endforeach
											</div>
										</div>
										<!-- /.card-body -->
									</div>
								</div>
							</div>
							@endforeach
              <!-- /.card -->

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
@endpush
</x-admin-layout>