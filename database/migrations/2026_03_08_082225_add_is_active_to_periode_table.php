<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('periode', function (Blueprint $table) {
            // Tambahkan kolom is_active, default true (aktif)
            $table->boolean('is_active')->default(true)->after('end_date');
        });
    }

    public function down()
    {
        Schema::table('periode', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
