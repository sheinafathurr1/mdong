<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'mahasiswa_id',
        'tipe_proyek', // ENUM: Perancangan, Analisa
        'nama_proyek',
        'teknik',
        'metode',
        'material',
        'narasi',
    ];

    // Relasi balik ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}