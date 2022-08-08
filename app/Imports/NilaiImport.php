<?php

namespace App\Imports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NilaiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $nilai = Nilai::find($row['id']);
            $nilai->kb = $row['kb'];
            $nilai->pengetahuan_nilai = $row['pengetahuan'];
            $nilai->keterampilan_nilai = $row['keterampilan'];
            $nilai->save();   
        }
    }
}
