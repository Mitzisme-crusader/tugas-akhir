<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokumen_so_model extends Model
{
    protected $table = 'dokumen_so';
    protected $primaryKey  = 'id_dokumen_so';
    protected $fillable = [
        'id_dokumen_so',
        'nomor_so',
        'tanggal_so',
        'judul_dokumen_spk',
        'nama_customer',
        'alamat_customer',
        'id_service',
        'status_aktif_dokumen',
    ];
}
