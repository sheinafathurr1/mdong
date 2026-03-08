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
}