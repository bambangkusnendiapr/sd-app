<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            // dd($row['nama']);
            $user = User::orderBy('id', 'DESC')->first();

            $user = User::create([
                'name' => 'Ortu ' . $row['nama'],
                'username' => strtolower(strtok($row['nama'], " ")) . $user->id,
                'email' => strtolower(strtok($row['nama'], " ")) . $user->id . '@gmail.com',
                'password' => bcrypt('password'),
            ]);

            $user->attachRole('siswa');

            Student::create([
                'user_id' => $user->id,
                'nama' => $row['nama'],
                'nis' => $row['no_induk'],
                'kelas' => $row['kelas'],
                'kelas_id' => $row['kelas_tipe'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tgl_lahir' => $row['tgl_lahir'],
                'jk' => $row['jenis_kelamin'],
                'sekolah_asal' => $row['pendidikan_sebelumnya'],
                'agama' => $row['agama'],
                'alamat' => $row['alamat'],
                'surat_awal' => $row['hafalan_surat_awal'],
                'nama_ayah' => $row['nama_ayah'],
                'nama_ibu' => $row['nama_ibu'],
                'kerja_ayah' => $row['kerja_ayah'],
                'kerja_ibu' => $row['kerja_ibu'],
                'jalan_ortu' => $row['alamat_jalan'],
                'kel_ortu' => $row['alamat_kelurahan'],
                'kec_ortu' => $row['alamat_kecamatan'],
                'kota_ortu' => $row['alamat_kota'],
                'prov_ortu' => $row['alamat_propinsi'],
                'hp_ortu' => $row['hp_ortu'],
                'nama_wali' => $row['nama_wali'],
                'kerja_wali' => $row['kerja_wali'],
                'alamat_wali' => $row['alamat_wali'],
                'hp_wali' => $row['hp_wali'],
            ]);
            
        }
    }
}
