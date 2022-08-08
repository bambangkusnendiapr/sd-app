<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function studentExport() 
    {
        return Excel::download(new StudentsExport, 'siswa.xlsx');
    }
}
