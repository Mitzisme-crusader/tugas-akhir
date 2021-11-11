<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class relasi_dokumen_so_extra_service_model extends Model
{
    protected $table = 'relasi_dokumen_so_extra_service';
    protected $primaryKey  = 'id_relasi_dokumen_so_extra_service';
    protected $fillable = [
        'nomor_so',
        'nama_service',
        'judul_dokumen_spk',
        'quantity_service',
        'container_service',
        'harga_service',
        'diskon_service',
        'pajak_service',
        'total_service'
    ];
}
