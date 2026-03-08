<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopikInterest extends Model
{
    protected $table = 'topik_interest';
    protected $primaryKey = 'topik_id';
    protected $fillable = ['dosen_id', 'periode_id', 'nama_topik', 'deskripsi', 'requirement', 'limit_bimbingan', 'limit_applied'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'dosen_id');
    }

    // Tambahkan relasi ini
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'periode_id');
    }
}