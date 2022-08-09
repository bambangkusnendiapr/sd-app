<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Psychologist;

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

    public function render()
    {
        $student = 'kosong';
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
        }
        return view('livewire.portofolio', [
            'students' => Student::all(),
            'siswa' => $student
        ]);
    }
}
