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
    Schema::create('project', function (Blueprint $table) {
        $table->id('project_id');
        $table->unsignedBigInteger('mahasiswa_id');
        $table->enum('tipe_proyek', ['Perancangan', 'Analisa']);
        $table->string('nama_proyek');
        $table->string('teknik')->nullable();
        $table->string('metode')->nullable();
        $table->string('material')->nullable();
        $table->text('narasi')->nullable();
        $table->timestamps();

        // Foreign Key
        $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('mahasiswa')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
