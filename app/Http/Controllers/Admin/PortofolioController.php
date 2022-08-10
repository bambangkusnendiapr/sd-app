<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class PortofolioController extends Controller
{
    public function downloadPortofolio(Request $request)
    {
        return view('admin.downloadPortofolio', [
            'student' => Student::find($request->siswaId)
        ]);
    }
}
