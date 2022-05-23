<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class relasi_tagihan_customer_extra_service_model extends Model
{
    protected $table = 'relasi_tagihan_customer_service';
    protected $primaryKey  = 'id_relasi_tagihan_customer_extra_service';
    protected $fillable = [
        'nomor_so',
        'id_tagihan_customer',
        'nama_service',
        'quantity_service',
        'container_service',
        'harga_service',
        'diskon_service',
        'pajak_service',
        'total_service'
    ];
}
