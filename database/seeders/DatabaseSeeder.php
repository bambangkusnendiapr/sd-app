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

        DB::table('menus')->insert([
            [
                'name' => 'User',
                'description' => 'User',
            ],
            [
                'name' => 'Profile',
                'description' => 'Profile',
            ],
            [
                'name' => 'Role',
                'description' => 'Role',
            ],
            [
                'name' => 'Permission',
                'description' => 'Permission',
            ],
            [
                'name' => 'Menu',
                'description' => 'Menu',
            ]
        ]);

        DB::table('kelas')->insert([
            [
                'nama' => ' Abu Bakar Ash-Shiddiq',
                'ket' => '-',
            ],
            [
                'nama' => 'Umar bin Khattab',
                'ket' => '-',
            ],
            [
                'nama' => 'Usman bin Affan',
                'ket' => '-',
            ],
            [
                'nama' => 'Ali bin Abi Thalib',
                'ket' => '-',
            ],
            [
                'nama' => 'Thalhah bin Ubaidillah',
                'ket' => '-',
            ]
        ]);
    }
}