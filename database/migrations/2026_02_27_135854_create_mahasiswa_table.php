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
    Schema::create('mahasiswa', function (Blueprint $table) {
        $table->id('mahasiswa_id');
        $table->string('username')->unique();
        $table->string('email')->unique();
        $table->string('password');
        $table->string('nama');
        $table->string('nim')->unique();
        $table->string('no_tlp')->nullable();
        $table->string('program_studi');
        $table->string('kelas')->nullable();
        $table->string('angkatan');
        $table->string('url_sosmed')->nullable();
        $table->string('visual_path')->nullable(); // Foto profil / cover portofolio
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
