<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periode';
    protected $primaryKey = 'periode_id';
    
    protected $fillable = [
        'nama_kode',
        'start_date',
        'end_date',
        'is_active'
    ];

    // Periode yang ditandai aktif DAN tanggal sekarang berada di dalam rentangnya
    public function scopeAktif($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now())
                     ->latest('start_date');
    }
}