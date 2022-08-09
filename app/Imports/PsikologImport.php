<?php

namespace App\Imports;

use App\Models\Psychologist;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class PsikologImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $data = new Psychologist;
            $data->tanggal = $row['tanggal'];
            $data->student_id = $row['siswa_id'];
            $data->iq = $row['iq'];
            $data->kemandirian = $row['kemandirian'];
            $data->kemampuan_bekerja = $row['kemampuan_bekerja'];
            $data->penyesuaian_diri = $row['penyesuaian_diri'];
            $data->save();            
        }
    }
}
