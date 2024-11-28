<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Pentadbir Utama ICT', 'guard_name' => 'web'],
            ['id' => 2, 'name' => 'Pentadbir R', 'guard_name' => 'web'],
            ['id' => 3, 'name' => 'Pengurus Tertinggi', 'guard_name' => 'web'],
            ['id' => 4, 'name' => 'Pengurus Projek PP', 'guard_name' => 'web'],
            ['id' => 5, 'name' => 'Pengurus Projek PRA', 'guard_name' => 'web'],
            ['id' => 6, 'name' => 'Pengurus Projek K', 'guard_name' => 'web'],
            ['id' => 7, 'name' => 'Pengurus Projek KR', 'guard_name' => 'web'],
            ['id' => 8, 'name' => 'Pengurus Projek EK', 'guard_name' => 'web'],
            ['id' => 9, 'name' => 'Pengurus Projek KD', 'guard_name' => 'web'],
            ['id' => 10, 'name' => 'Pengurus Projek INFRA', 'guard_name' => 'web'],
            ['id' => 11, 'name' => 'Pengurus Projek TW', 'guard_name' => 'web'],
            ['id' => 12, 'name' => 'Pengguna PP', 'guard_name' => 'web'],
            ['id' => 13, 'name' => 'Pengguna PRA', 'guard_name' => 'web'],
            ['id' => 14, 'name' => 'Pengguna K', 'guard_name' => 'web'],
            ['id' => 15, 'name' => 'Pengguna KR', 'guard_name' => 'web'],
            ['id' => 16, 'name' => 'Pengguna EK', 'guard_name' => 'web'],
            ['id' => 17, 'name' => 'Pengguna KD', 'guard_name' => 'web'],
            ['id' => 18, 'name' => 'Pengguna INFRA', 'guard_name' => 'web'],
            ['id' => 19, 'name' => 'Pengguna UD', 'guard_name' => 'web'],
            ['id' => 20, 'name' => 'Pengguna TW', 'guard_name' => 'web'],
            ['id' => 21, 'name' => 'Pengguna Belum Daftar', 'guard_name' => 'web'],
        ]);
    }
}
