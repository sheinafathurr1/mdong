<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Data Dummy Mahasiswa
        DB::table('mahasiswa')->insert([
            'username' => 'switch_mhs',
            'email' => 'switch@student.campus.ac.id',
            'password' => Hash::make('password123'), // Password default
            'nama' => 'Switch',
            'nim' => '1234567890',
            'no_tlp' => '081234567890',
            'program_studi' => 'S1 Kriya',
            'kelas' => 'KR-44-01',
            'angkatan' => '2021',
            'url_sosmed' => 'https://instagram.com/switch_kriya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Buat Data Dummy Dosen Biasa
        DB::table('dosen')->insert([
            'username' => 'dosen_biasa',
            'email' => 'dosen1@campus.ac.id',
            'password' => Hash::make('password123'),
            'nama' => 'Dr. Budi Santoso, M.Sn.',
            'kode' => 'BDS',
            'nip' => '198001012005011001',
            'no_tlp' => '082345678901',
            'program_studi' => 'S1 Kriya',
            'is_admin' => 'NO', // Dosen biasa
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Buat Data Dummy Dosen Prodi (Admin)
        DB::table('dosen')->insert([
            'username' => 'dosen_prodi',
            'email' => 'prodi@campus.ac.id',
            'password' => Hash::make('password123'),
            'nama' => 'Prof. Siti Aminah, M.Ds.',
            'kode' => 'STA',
            'nip' => '197502022000032001',
            'no_tlp' => '083456789012',
            'program_studi' => 'S1 Kriya',
            'is_admin' => 'YES', // Dosen dengan akses Prodi
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}