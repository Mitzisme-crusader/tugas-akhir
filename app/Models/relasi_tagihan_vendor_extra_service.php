<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relasi_tagihan_vendor_extra_service extends Model
{
    protected $table = 'relasi_tagihan_vendor_extra_service';
    protected $primaryKey  = 'id_relasi_tagihan_vendor_extra_service';
    protected $fillable = [
        'id_tagihan_vendor',
        'nama_service',
        'quantity_service',
        'container_service',
        'harga_service',
        'diskon_service',
        'pajak_service',
        'total_service',
        'bank_pelunasan',
        'bank_tujuan_pembayaran'
    ];
}
