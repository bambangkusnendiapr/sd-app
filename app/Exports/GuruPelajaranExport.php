<?php

namespace App\Exports;

use App\Models\GuruPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GuruPelajaranExport implements FromView
{
    public function view(): View
    {
        return view('exports.guruPelajaran');
    }
}
