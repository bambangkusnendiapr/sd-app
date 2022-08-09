<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Exports\PsikologExport;
use App\Exports\TahsinExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function studentExport() 
    {
        return Excel::download(new StudentsExport, 'siswa.xlsx');
    }

    public function psikologExport() 
    {
        return Excel::download(new PsikologExport, 'psikolog.xlsx');
    }

    public function tahsinExport() 
    {
        return Excel::download(new TahsinExport, 'tahsin.xlsx');
    }
}
