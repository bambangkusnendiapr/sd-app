<?php

namespace App\Exports;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Rapor;
use App\Models\Master\Jurusan;
use App\Models\Master\Semester;
use App\Models\Master\Pelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NilaiExport implements FromView
{
    public function view(): View
    {
        $sessionNilai = session()->get('sessionNilai');
        $pilihKelas = $sessionNilai['pilihKelas'];
        $pilihJurusan = $sessionNilai['pilihJurusan'];
        $pilihSemester = $sessionNilai['pilihSemester'];
        $pilihPelajaran = $sessionNilai['pilihPelajaran'];

        $siswa = Siswa::where('kelas', $pilihKelas)->where('jurusan_id', $pilihJurusan)->get('id');

        $rapor = Rapor::where('kelas', $pilihKelas)->where('semester_id', $pilihSemester)->whereIn('siswa_id', $siswa)->get('id');

        $nilai = Nilai::whereIn('rapor_id', $rapor)->where('pelajaran_id', $pilihPelajaran)->get();

        return view('exports.nilai', [
            'nilai' => $nilai,
            'kelas' => $pilihKelas,
            'jurusan' => Jurusan::find($pilihJurusan),
            'semester' => Semester::find($pilihSemester),
            'pelajaran' => Pelajaran::find($pilihPelajaran)
        ]);
    }
}
