<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class TestingAccountsSeeder extends Seeder
{
    /**
     * Seed 5 akun mahasiswa + 5 akun dosen untuk kebutuhan testing.
     * Jalankan manual: php artisan db:seed --class=TestingAccountsSeeder
     */
    public function run(): void
    {
        $mahasiswaList = [
            ['username' => 'mhs_test1', 'nama' => 'Ahmad Fajar',   'nim' => '2100001', 'kelas' => 'KR-44-01'],
            ['username' => 'mhs_test2', 'nama' => 'Bunga Citra',   'nim' => '2100002', 'kelas' => 'KR-44-01'],
            ['username' => 'mhs_test3', 'nama' => 'Chandra Wijaya','nim' => '2100003', 'kelas' => 'KR-44-02'],
            ['username' => 'mhs_test4', 'nama' => 'Dewi Lestari',  'nim' => '2100004', 'kelas' => 'KR-44-02'],
            ['username' => 'mhs_test5', 'nama' => 'Eka Putra',     'nim' => '2100005', 'kelas' => 'KR-44-03'],
        ];

        foreach ($mahasiswaList as $mhs) {
            Mahasiswa::updateOrCreate(
                ['username' => $mhs['username']],
                [
                    'email' => $mhs['username'] . '@student.campus.ac.id',
                    'password' => 'password123', // otomatis di-hash lewat mutator model
                    'nama' => $mhs['nama'],
                    'nim' => $mhs['nim'],
                    'no_tlp' => '08123456' . $mhs['nim'],
                    'program_studi' => 'S1 Kriya',
                    'kelas' => $mhs['kelas'],
                    'angkatan' => '2021',
                ]
            );
        }

        $dosenList = [
            ['username' => 'dosen_test1', 'nama' => 'Dr. Rina Kusuma, M.Sn.',    'kode' => 'RKM', 'nip' => '199001012015012001', 'is_admin' => 'NO'],
            ['username' => 'dosen_test2', 'nama' => 'Dr. Bayu Aji, M.Ds.',       'kode' => 'BYA', 'nip' => '198505052013021002', 'is_admin' => 'NO'],
            ['username' => 'dosen_test3', 'nama' => 'Dr. Citra Dewi, M.Sn.',     'kode' => 'CTD', 'nip' => '198703032014032003', 'is_admin' => 'NO'],
            ['username' => 'dosen_test4', 'nama' => 'Dr. Dian Permata, M.Ds.',   'kode' => 'DPM', 'nip' => '199202022018022004', 'is_admin' => 'NO'],
            // Dosen ke-5 dijadikan admin prodi supaya modul Prodi (Setting Periode) juga bisa dites
            ['username' => 'dosen_test5', 'nama' => 'Prof. Eko Santosa, M.Ds.',  'kode' => 'EKS', 'nip' => '197001012000011005', 'is_admin' => 'YES'],
        ];

        foreach ($dosenList as $dosen) {
            Dosen::updateOrCreate(
                ['username' => $dosen['username']],
                [
                    'email' => $dosen['username'] . '@campus.ac.id',
                    'password' => 'password123', // otomatis di-hash lewat mutator model
                    'nama' => $dosen['nama'],
                    'kode' => $dosen['kode'],
                    'nip' => $dosen['nip'],
                    'no_tlp' => '08234567' . substr($dosen['nip'], -4),
                    'program_studi' => 'S1 Kriya',
                    'is_admin' => $dosen['is_admin'],
                ]
            );
        }

        $this->command->info('5 akun mahasiswa & 5 akun dosen untuk testing berhasil dibuat (password: password123).');
    }
}
