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
    Schema::create('application', function (Blueprint $table) {
        $table->id('application_id');
        $table->unsignedBigInteger('mahasiswa_id');
        $table->unsignedBigInteger('topik_id');
        $table->unsignedBigInteger('pembimbing_2_id')->nullable();
        $table->dateTime('tanggal_submit')->nullable();
        $table->dateTime('tanggal_response')->nullable();
        $table->enum('status', [
            'DRAFT', 
            'APPLIED', 
            'APPROVED-PBB1', 
            'APPROVED-FULL', 
            'REJECTED'
        ])->default('DRAFT');
        $table->timestamps();

        // Foreign Keys
        $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('mahasiswa')->onDelete('cascade');
        $table->foreign('topik_id')->references('topik_id')->on('topik_interest')->onDelete('cascade');
        $table->foreign('pembimbing_2_id')->references('dosen_id')->on('dosen')->onDelete('set null');

        // Constraint: Mencegah apply dobel ke topik yang sama
        $table->unique(['mahasiswa_id', 'topik_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application');
    }
};
