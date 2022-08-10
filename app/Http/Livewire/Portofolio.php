<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Dhuha;
use App\Models\Psychologist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Portofolio extends Component
{
    public $siswaId = 'Semua';

    public $nama;
    public $nis;
    public $kelas;
    public $kelasTipe;
    public $tempatLahir;
    public $tglLahir;
    public $jk;
    public $alamat;
    public $gambar;

    public $iq;
    public $kemandirian;
    public $kemampuanBekerja;
    public $penyesuaianDiri;

    public $persenDhuha;

    public function render()
    {
        $student = 'kosong';

        if(Auth::user()->hasRole('siswa')) {
            $student = Student::where('user_id', Auth::user()->id)->first();
            $this->nama = $student->nama;
            $this->nis = $student->nis;
            $this->kelas = $student->kelas;
            $this->kelasTipe = $student->kls->nama;
            $this->tempatLahir = $student->tempat_lahir;
            $this->tglLahir = $student->tgl_lahir;
            $this->jk = $student->jk;
            $this->alamat = $student->alamat;
            $this->gambar = $student->gambar;

            //ambil data dhuha >= tanggal masuk siswa dan jumlahkan
            $jumlahDhuha = Dhuha::where('tanggal', '>=', $student->tanggal_masuk)->count();

            //ambil data sholat dhuha siswa
            $jumlahDhuhaSiswa = DB::table('dhuha_student')->where('student_id', $student->id)->count();

            $this->persenDhuha = $jumlahDhuhaSiswa / $jumlahDhuha * 100;
        }

        if($this->siswaId != 'Semua') {
            $student = Student::find($this->siswaId);
            $this->nama = $student->nama;
            $this->nis = $student->nis;
            $this->kelas = $student->kelas;
            $this->kelasTipe = $student->kls->nama;
            $this->tempatLahir = $student->tempat_lahir;
            $this->tglLahir = $student->tgl_lahir;
            $this->jk = $student->jk;
            $this->alamat = $student->alamat;
            $this->gambar = $student->gambar;

            //ambil data dhuha >= tanggal masuk siswa dan jumlahkan
            $jumlahDhuha = Dhuha::where('tanggal', '>=', $student->tanggal_masuk)->count();

            //ambil data sholat dhuha siswa
            $jumlahDhuhaSiswa = DB::table('dhuha_student')->where('student_id', $student->id)->count();

            $this->persenDhuha = $jumlahDhuhaSiswa / $jumlahDhuha * 100;

        }
        return view('livewire.portofolio', [
            'students' => Student::all(),
            'siswa' => $student
        ]);
    }
}
