<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application', function (Blueprint $table) {
            $table->id('application_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('topik_id');
            
            // ENUM disederhanakan murni menjadi 3 status
            $table->enum('status', ['APPLIED', 'APPROVED', 'REJECTED'])->default('APPLIED');
            
            $table->timestamp('tanggal_submit')->useCurrent();
            $table->timestamp('tanggal_response')->nullable();
            $table->timestamps();

            // Relasi (Hanya ke Mahasiswa dan Topik)
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('topik_id')->references('topik_id')->on('topik_interest')->onDelete('cascade');
            $table->unique(['mahasiswa_id', 'topik_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application');
    }
};

