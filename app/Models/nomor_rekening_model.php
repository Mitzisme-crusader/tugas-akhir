<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nomor_rekening_model extends Model
{
    protected $table = 'nomor_rekening';
    protected $primaryKey  = 'id_rekening';
    protected $fillable = [
        'nomor_rekening',
        'nama_rekening',
        'nomor_COA',
        'total_rekening',
        'status_aktif',
    ];
}
