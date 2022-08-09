<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('dashboard', [
            'siswa' => Student::count(),
            'laki' => Student::where('jk', 'Laki-laki')->count(),
            'perempuan' => Student::where('jk', 'Perempuan')->count(),
        ]);
    }
}
