<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Ortu;
use App\Models\Guru;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(LaratrustSeeder::class);
        DB::table('ekstrakurikulers')->insert([
            ['nama' => 'Rochis/Marawis'],
            ['nama' => 'Basket Ball'],
            ['nama' => 'Volley'],
            ['nama' => 'Club Bahasa Francis'],
            ['nama' => 'Keputrian'],
            ['nama' => 'English Metting Club'],
            ['nama' => 'Futsal'],
            ['nama' => 'Paskibra'],
            ['nama' => 'Pramuka'],
        ]);
        DB::table('karakters')->insert([
            ['nama' => 'Integritas'],
            ['nama' => 'Religius'],
            ['nama' => 'Nasionalis'],
            ['nama' => 'Mandiri'],
            ['nama' => 'Gotong Royong'],
        ]);
        DB::table('jurusans')->insert([
            ['nama' => 'TP-1', 'ket' => 'Teknik Pemesinan',],
            ['nama' => 'TP-2', 'ket' => 'Teknik Pemesinan',],
            ['nama' => 'TP-3', 'ket' => 'Teknik Pemesinan',],
            ['nama' => 'TKRO-1', 'ket' => 'Teknik Kendaraan Ringan dan Otomotif',],
            ['nama' => 'TKRO-2', 'ket' => 'Teknik Kendaraan Ringan dan Otomotif',],
            ['nama' => 'TKRO-3', 'ket' => 'Teknik Kendaraan Ringan dan Otomotif',],
            ['nama' => 'TSM-1', 'ket' => 'Teknik Sepeda Motor',],
            ['nama' => 'TSM-2', 'ket' => 'Teknik Sepeda Motor',],
            ['nama' => 'TSM-3', 'ket' => 'Teknik Sepeda Motor',],
            ['nama' => 'TKJ-1', 'ket' => 'Teknik Komputer Jaringan',],
            ['nama' => 'TKJ-2', 'ket' => 'Teknik Komputer Jaringan',],
            ['nama' => 'TKJ-3', 'ket' => 'Teknik Komputer Jaringan',],
        ]);
        DB::table('semesters')->insert([
            ['nama' => 'Ganjil', 'tahun' => '2021/2022',],
            ['nama' => 'Genap', 'tahun' => '2021/2022',],
        ]);
        DB::table('kelompoks')->insert([
            ['nama' => 'A. Muatan Nasional'],
            ['nama' => 'B. Muatan Kewilayahan'],
            ['nama' => 'C1. Dasar Bidang Keahlian'],
            ['nama' => 'C2. Dasar Program Keahlian'],
        ]);
        DB::table('pelajarans')->insert([
            ['kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam', 'kelompok_id' => 1,],
            ['kode' => 'PPKN', 'nama' => 'Pendidikan Pancasila dan Kewarganegaraan', 'kelompok_id' => 1,],
            ['kode' => 'B. Indo', 'nama' => 'Bahasa Indonesia', 'kelompok_id' => 1,],
            ['kode' => 'Sejarah', 'nama' => 'Sejarah', 'kelompok_id' => 1,],
            ['kode' => 'MTK', 'nama' => 'Matematika', 'kelompok_id' => 1,],
            ['kode' => 'B. Ing', 'nama' => 'Bahasa Inggris', 'kelompok_id' => 1,],
            ['kode' => 'SB', 'nama' => 'Seni Budaya', 'kelompok_id' => 2,],
            ['kode' => 'PJOK', 'nama' => 'Pendidikan Jasmani, Olahraga dan Kesehatan', 'kelompok_id' => 2,],
            ['kode' => 'PLH', 'nama' => 'Pemeliharaan Lingkungan Hidup', 'kelompok_id' => 2,],
            ['kode' => 'BA', 'nama' => 'Bahasa Asing (Jepang)', 'kelompok_id' => 2,],
            ['kode' => 'BS', 'nama' => 'Bahasa Sunda', 'kelompok_id' => 2,],
            ['kode' => 'SKD', 'nama' => 'Simulasi dan Komunikasi Digital', 'kelompok_id' => 3,],
            ['kode' => 'Fisika', 'nama' => 'Fisika', 'kelompok_id' => 3,],
            ['kode' => 'Kimia', 'nama' => 'Kimia', 'kelompok_id' => 3,],
            ['kode' => 'GAMTEK', 'nama' => 'GAMTEK', 'kelompok_id' => 4,],
            ['kode' => 'PDTM', 'nama' => 'PDTM', 'kelompok_id' => 4,],
            ['kode' => 'DPTM', 'nama' => 'DPTM', 'kelompok_id' => 4,],
            ['kode' => 'PDO', 'nama' => 'PDO', 'kelompok_id' => 4,],
            ['kode' => 'TDO', 'nama' => 'TDO', 'kelompok_id' => 4,],
            ['kode' => 'SISKOM', 'nama' => 'SISKOM', 'kelompok_id' => 4,],
            ['kode' => 'PRODAS', 'nama' => 'PRODAS', 'kelompok_id' => 4,],
            ['kode' => 'KJD', 'nama' => 'KJD', 'kelompok_id' => 4,],
            ['kode' => 'DDG', 'nama' => 'DDG', 'kelompok_id' => 4,],
        ]);

        // //Data Guru
        // for($i = 1; $i <= 20; $i++){
        //     $user = User::create([
        //         'name' => 'Guru ' . $i,
        //         'email' => 'guru' . $i . '@gmail.com',
        //         'password' => bcrypt('passsword'),
        //     ]);

        //     DB::table('role_user')->insert([
        //         'role_id' => 3,
        //         'user_id' => $user->id,
        //         'user_type' => 'App\Models\User',
        //     ]);

        //     DB::table('gurus')->insert([
        //         'user_id' => $user->id,
        //     ]);
        // }

        // //Data Ortu dan Siswa
        // for($i = 1; $i <= 36; $i++) {
        //     $userOrtu = User::create([
        //         'name' => 'Ortu ' . $i,
        //         'email' => 'ortu' . $i . '@gmail.com',
        //         'password' => bcrypt('passsword'),
        //     ]);

        //     $ortu = Ortu::create([
        //         'user_id' => $userOrtu->id,
        //     ]);

        //     $userSiswa = User::create([
        //         'name' => 'Siswa ' . $i,
        //         'email' => 'siswa' . $i . '@gmail.com',
        //         'password' => bcrypt('passsword'),
        //     ]);

        //     DB::table('siswas')->insert([
        //         'user_id' => $userSiswa->id,
        //         'jurusan_id' => rand(1,12),
        //         'ortu_id' => $ortu->id,
        //         'kelas' => 'X',
        //     ]);
        // }

        // //Data Wali Kelas
        // for($i = 1; $i <= 12; $i++){

        //     DB::table('wali_kelas')->insert([
        //         'guru_id' => $i,
        //         'kelas' => 'X',
        //         'jurusan_id' => $i,
        //     ]);

        //     $guru = Guru::find($i);

        //     DB::table('role_user')
        //       ->where('user_id', $guru->user_id)
        //       ->update([
        //         'role_id' => 2,
        //         'user_id' => $guru->user_id,
        //         'user_type' => 'App\Models\User',
        //       ]);
        // }

        // //Data Guru dan Pelajaran Muatan Nasional, Muatan Kewilayahan dan Dasar Bidang Keahlian
        // for($i = 1; $i <= 12; $i++){

        //     for($j = 1; $j <= 12; $j++) {

        //         DB::table('guru_pelajarans')->insert([
        //             'pelajaran_id' => $i,
        //             'guru_id' => $i,
        //             'kelas' => 'X',
        //             'jurusan_id' => $j,
        //         ]);

        //     }

        // }

        // //Guru dan Pelajaran GAMTEK
        // for($i = 1; $i <= 9; $i++) {

        //     DB::table('guru_pelajarans')->insert([
        //         'pelajaran_id' => 13,
        //         'guru_id' => 13,
        //         'kelas' => 'X',
        //         'jurusan_id' => $i,
        //     ]);

        // }

        // //Guru dan Pelajaran PDTM DPTM
        // for($i = 14; $i <= 15; $i++){

        //     for($j = 1; $j <= 3; $j++) {

        //         DB::table('guru_pelajarans')->insert([
        //             'pelajaran_id' => $i,
        //             'guru_id' => $i,
        //             'kelas' => 'X',
        //             'jurusan_id' => $j,
        //         ]);

        //     }

        // }

        // //Guru dan Pelajaran PDO TDO
        // for($i = 16; $i <= 17; $i++){

        //     for($j = 4; $j <= 9; $j++) {

        //         DB::table('guru_pelajarans')->insert([
        //             'pelajaran_id' => $i,
        //             'guru_id' => $i,
        //             'kelas' => 'X',
        //             'jurusan_id' => $j,
        //         ]);

        //     }

        // }

        // //Guru dan Pelajaran SISKOM, PRODAS, KJD
        // for($i = 18; $i <= 20; $i++){

        //     for($j = 10; $j <= 12; $j++) {

        //         DB::table('guru_pelajarans')->insert([
        //             'pelajaran_id' => $i,
        //             'guru_id' => $i,
        //             'kelas' => 'X',
        //             'jurusan_id' => $j,
        //         ]);

        //     }

        // }

        // //Guru dan Pelajaran DDG
        // for($i = 10; $i <= 12; $i++) {

        //     DB::table('guru_pelajarans')->insert([
        //         'pelajaran_id' => 21,
        //         'guru_id' => 20,
        //         'kelas' => 'X',
        //         'jurusan_id' => $i,
        //     ]);

        // }
    }
}
