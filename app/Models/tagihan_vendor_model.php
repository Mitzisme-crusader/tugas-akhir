<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tagihan_vendor_model extends Model
{
    protected $table = 'tagihan_vendor';
    protected $primaryKey  = 'id_tagihan_vendor';
    protected $fillable = [
        'nomor_so',
        'keterangan_tagihan',
        'hutang',
        'total_service'
    ];
}
