<?php

namespace App\Imports;

use App\Models\Tahsin;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class TahsinImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $data = new Tahsin;
            $data->tanggal = $row['tanggal'];
            $data->student_id = $row['siswa_id'];
            $data->jilid = $row['jilid'];
            $data->halaman = $row['halaman'];
            $data->murajaah = $row['murajaah'];
            $data->ziyadah = $row['ziyadah'];
            $data->nilai = $row['nilai'];
            $data->save();            
        }
    }
}
