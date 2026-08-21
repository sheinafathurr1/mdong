<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topik_interest', function (Blueprint $table) {
            // Jumlah slot reservasi (antrean) yang sedang terpakai: bertambah saat
            // mahasiswa apply, berkurang lagi kalau aplikasinya ditolak. Kuota
            // reservasi total = limit_bimbingan * 2 (lihat TopikInterest::getLimitReservasiAttribute).
            $table->integer('reservasi_applied')->default(0)->after('limit_applied');
        });

        // Backfill: aplikasi yang sudah ada (APPLIED/APPROVED) dianggap sudah
        // memakai slot reservasi, supaya kuota reservasi tidak "bocor" untuk
        // data yang dibuat sebelum kolom ini ada.
        DB::table('topik_interest')->update([
            'reservasi_applied' => DB::raw(
                '(select count(*) from application where application.topik_id = topik_interest.topik_id and application.status in (\'APPLIED\', \'APPROVED\'))'
            ),
        ]);
    }

    public function down(): void
    {
        Schema::table('topik_interest', function (Blueprint $table) {
            $table->dropColumn('reservasi_applied');
        });
    }
};
