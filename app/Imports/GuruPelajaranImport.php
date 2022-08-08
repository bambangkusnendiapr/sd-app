<?php

namespace App\Imports;

use App\Models\GuruPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruPelajaranImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            GuruPelajaran::create([
                'pelajaran_id' => $row['id_pelajaran'],
                'guru_id' => $row['id_guru'],
                'jurusan_id' => $row['id_jurusan'],
                'kelas' => $row['kelas'],
            ]);
            
        }
    }
}
