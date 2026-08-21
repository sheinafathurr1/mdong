<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            // Foto profil dosen (sudah dipakai di resources/views/dosen/layouts/app.blade.php
            // sebelum kolomnya ada, jadi selama ini selalu fallback ke inisial nama)
            $table->string('visual_path')->nullable()->after('no_tlp');

            // Link undangan grup chat bimbingan (WhatsApp/Telegram/dll) yang dipakai
            // mahasiswa untuk gabung setelah aplikasinya APPROVED
            $table->string('link_grup')->nullable()->after('visual_path');
        });
    }

    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropColumn(['visual_path', 'link_grup']);
        });
    }
};
