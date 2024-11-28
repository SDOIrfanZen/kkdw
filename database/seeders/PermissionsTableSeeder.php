<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'Melihat Senarai Pengguna', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'name' => 'Meluluskan Permohonan Baru Pengguna', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 3, 'name' => 'Mengemaskini Maklumat Pengguna', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 4, 'name' => 'Mengemaskini Kata Laluan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 5, 'name' => 'Mengemaskini Status Pengguna (Aktif/Tidak Aktif)', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 6, 'name' => 'Menghapuskan Akaun Pengguna', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 7, 'name' => 'Melihat Senarai Peranan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 8, 'name' => 'Daftar Peranan Baru', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 9, 'name' => 'Mengemaskini Peranan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 10, 'name' => 'Mengemaskini Status Peranan (Aktif/Tidak Aktif)', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 11, 'name' => 'Menghapuskan Peranan Pengguna', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 12, 'name' => 'Mengemaskini status capaian (aktif / tidak aktif)', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 13, 'name' => 'Muat Naik Data', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 14, 'name' => 'Purata Nasional', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 15, 'name' => 'Unjuran', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 16, 'name' => 'Dashboard Utama', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 17, 'name' => 'Prestasi Perbelanjaan Negeri', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 18, 'name' => 'Dashboard Infrastruktur Asas & Laporan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 19, 'name' => 'Dashboard Ekonomi & Laporan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 20, 'name' => 'Dashboard Modal Insan & Laporan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 21, 'name' => 'Dashboard Usahawan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 22, 'name' => 'Dashboard Profil Kampung', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 23, 'name' => 'Papar Maklumat Profil Pengguna', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 24, 'name' => 'Kemaskini Maklumat Pengguna (data semasa daftar akaun)', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 25, 'name' => 'Tukar Kata Laluan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 26, 'name' => 'Papar Senarai Log', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 27, 'name' => 'Carian Log (hari atau pengguna)', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 28, 'name' => 'Export Excel/PDF', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 29, 'name' => 'Prestasi Perbelanjaan Bahagian PP', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 30, 'name' => 'Prestasi Perbelanjaan Bahagian PRA', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 31, 'name' => 'Prestasi Perbelanjaan Bahagian K', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 32, 'name' => 'Prestasi Perbelanjaan Bahagian KR', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 33, 'name' => 'Prestasi Perbelanjaan Bahagian EK', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 34, 'name' => 'Prestasi Perbelanjaan Bahagian KD', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 35, 'name' => 'Prestasi Perbelanjaan Bahagian INFRA', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 36, 'name' => 'Prestasi Perbelanjaan Bahagian TW', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 37, 'name' => 'Prestasi Perbelanjaan Bahagian UD', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 38, 'name' => 'Daftar sebagai pengguna', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 39, 'name' => 'Log masuk portal', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 40, 'name' => 'Lupa kata laluan', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
            ['id' => 41, 'name' => 'Log keluar portal', 'guard_name' => 'web', 'created_at' => null, 'updated_at' => null],
        ]);
    }
}
