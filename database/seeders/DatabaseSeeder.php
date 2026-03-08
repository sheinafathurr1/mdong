<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DummyUsersSeeder::class,
            // Nanti kamu bisa tambahkan seeder lain di sini (misal: PeriodeSeeder)
        ]);
    }
}