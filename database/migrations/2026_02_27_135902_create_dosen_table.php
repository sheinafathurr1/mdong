<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('dosen', function (Blueprint $table) {
        $table->id('dosen_id');
        $table->string('username')->unique();
        $table->string('email')->unique();
        $table->string('password');
        $table->string('nama');
        $table->string('kode')->unique();
        $table->string('nip')->unique()->nullable();
        $table->string('no_tlp')->nullable();
        $table->string('program_studi');
        $table->enum('is_admin', ['YES', 'NO'])->default('NO'); // Akses untuk Prodi
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
