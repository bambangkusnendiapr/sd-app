<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ImportController extends Controller
{
    public function studentsImport(Request $request) 
    {
        $this->validate($request,[
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));
        
        Alert::success('Sukses', 'Data Berhasil Diupload');
        return redirect()->route('student');
    }
}
