<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Ortu;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $random = rand(1000, 9999);

            $username = substr($row['email'], 0, strpos($row['email'], '@'));

            $userOrtu = User::create([
                'name' => 'Ortu ' . $row['nama'],
                'username' => $random . 'ortu_' . $username,
                'email' => $random . 'ortu_' . $row['email'],
                'password' => bcrypt($row['password']),
            ]);

            $userOrtu->attachRole('wali_siswa');

            $ortu = Ortu::create([
                'user_id' => $userOrtu->id,
            ]);

            $userSiswa = User::create([
                'name' => $row['nama'],
                'username' => $random . $username,
                'email' => $random . $row['email'],
                'password' => bcrypt($row['password']),
            ]);

            $userSiswa->attachRole('siswa');

            Siswa::create([
                'user_id' => $userSiswa->id,
                'jurusan_id' => $row['id_jurusan'],
                'ortu_id' => $ortu->id,
                'kelas' => $row['kelas'],
                'nis' => $row['no_induk'],
            ]);
            
        }
    }
}
