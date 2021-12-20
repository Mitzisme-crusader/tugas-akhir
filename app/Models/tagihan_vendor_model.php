<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tagihan_vendor_model extends Model
{
    protected $table = 'tagihan_vendor';
    protected $primaryKey  = 'id_tagihan_vendor';
    protected $fillable = [
        'nomor_so',
        'vendor_service',
        'nama_service',
        'quantity_service',
        'container_service',
        'harga_service',
        'diskon_service',
        'pajak_service',
        'keterangan_service',
        'hutang',
        'total_service'
    ];
}
