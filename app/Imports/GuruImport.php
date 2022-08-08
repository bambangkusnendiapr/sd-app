<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $random = rand(1000, 9999);

            $username = substr($row['email'], 0, strpos($row['email'], '@'));

            $user = User::create([
                'name' => $row['nama'],
                'username' => $random . $username,
                'email' => $random . $row['email'],
                'password' => bcrypt($row['password']),
            ]);

            Guru::create([
                'user_id' => $user->id,
                'kode' => $row['kode'],
            ]);

            $user->attachRole('guru');
            
        }
    }
}
