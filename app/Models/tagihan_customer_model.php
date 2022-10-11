<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tagihan_customer_model extends Model
{
    protected $table = 'tagihan_customer';
    protected $primaryKey  = 'id_tagihan_customer';
    protected $fillable = [
        'nomor_so',
        'bank_pelunasan',
        'piutang',
        'keterangan_tagihan',
        'total_service'
    ];
}
