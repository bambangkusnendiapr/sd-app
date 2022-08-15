<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Dhuha;
use App\Models\Fardhu;
use App\Models\Shaum;
use Illuminate\Support\Facades\DB;

class PortofolioController extends Controller
{
    public function downloadPortofolio(Request $request)
    {
        return view('admin.downloadPortofolio', [
            'student' => Student::find($request->siswaId),
            'persenDhuha' => $request->persenDhuha,
            'persenFardhu' => $request->persenFardhu,
            'persenShaum' => $request->persenShaum,
        ]);
    }

    public function getDownloadPortofolio()
    {
        return redirect()->route('portofolio');
    }
}
