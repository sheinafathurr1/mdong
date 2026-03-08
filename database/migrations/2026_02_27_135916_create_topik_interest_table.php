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
    Schema::create('topik_interest', function (Blueprint $table) {
        $table->id('topik_id');
        $table->unsignedBigInteger('dosen_id');
        $table->unsignedBigInteger('periode_id');
        $table->string('nama_topik');
        $table->text('deskripsi');
        $table->text('requirement')->nullable();
        $table->integer('limit_bimbingan')->default(0);
        $table->integer('limit_applied')->default(0);
        $table->timestamps();

        // Foreign Keys
        $table->foreign('dosen_id')->references('dosen_id')->on('dosen')->onDelete('cascade');
        $table->foreign('periode_id')->references('periode_id')->on('periode')->onDelete('cascade');
        
        // Constraint: 1 dosen = 1 topik per periode
        $table->unique(['dosen_id', 'periode_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik_interest');
    }
};
