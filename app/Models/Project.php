<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $primaryKey = 'project_id';

    // Daftar pilihan dropdown, mengikuti Matrix Aplikasi Pra-TA
    const TEKNIK_OPTIONS = [
        'REKATRAKIT UMUM',
        'REKATRAKIT UMUM - WOVEN',
        'REKATRAKIT UMUM - NON WOVEN',
        'REKALATAR UMUM',
        'REKALATAR - BATIK',
        'REKALATAR - PEWARNA ALAM',
        'REKALATAR - ECO PRINT',
        'REKALATAR - MOTIF',
        'REKALATAR - BLOCK PRINTING',
        'REKALATAR - EMBELLISHMENT',
        'JAHIT & POLA DASAR',
    ];

    const SKILL_SET_OPTIONS = [
        'KAJIAN MODEST WEAR',
        'KAJIAN LIFESTYLE / GAYA HIDUP',
        'KAJIAN SUSTAINABLE FASHION',
        'KAJIAN TREND FASHION',
        'KAJIAN BATIK',
        'KAJIAN LOCAL BRAND',
        'JAHIT & POLA DASAR',
        'ADOBE ILLUSTRATOR',
        'CLO 3D',
        'BUSINESS MODEL CANVAS',
        'KOLABORASI KOMUNITAS / MITRA UMKM',
    ];

    const MATERIAL_OPTIONS = [
        'MATERIAL SINTETIS',
        'MATERIAL ALAMI',
        'MATERIAL CAMPURAN',
    ];

    protected $fillable = [
        'mahasiswa_id',
        'tipe_proyek', // ENUM: Perancangan, Analisa
        'nama_proyek',
        'teknik',
        'metode', // Skill Set
        'material',
        'narasi',
    ];

    // Relasi balik ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}