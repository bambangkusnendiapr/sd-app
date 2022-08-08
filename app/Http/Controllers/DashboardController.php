<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('dashboard', [
            'guru' => 1,
            'siswa' => 2,
            'kelas' => 3,
            'ekstrakurikuler' => 4,
        ]);
    }
}
