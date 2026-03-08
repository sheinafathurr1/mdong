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
    Schema::create('periode', function (Blueprint $table) {
        $table->id('periode_id');
        $table->string('nama_kode'); // misal: "Genap 2025/2026"
        $table->date('start_date');
        $table->date('end_date');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
