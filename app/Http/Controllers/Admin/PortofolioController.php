<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Dhuha;
use Illuminate\Support\Facades\DB;

class PortofolioController extends Controller
{
    public function downloadPortofolio(Request $request)
    {
        $student = Student::find($request->siswaId);
        //ambil data dhuha >= tanggal masuk siswa dan jumlahkan
        $jumlahDhuha = Dhuha::where('tanggal', '>=', $student->tanggal_masuk)->count();

        //ambil data sholat dhuha siswa
        $jumlahDhuhaSiswa = DB::table('dhuha_student')->where('student_id', $student->id)->count();

        $persenDhuha = $jumlahDhuhaSiswa / $jumlahDhuha * 100;

        return view('admin.downloadPortofolio', [
            'student' => $student,
            'persenDhuha' => $persenDhuha
        ]);
    }
}
