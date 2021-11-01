<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokumen_so_model extends Model
{
    protected $table = 'dokumen_so';
    protected $primaryKey  = 'id_dokumen_so';
    protected $fillable = [
        'id_dokumen_spk',
        'nomor_so',
        'tanggal_so',
        'id_dokumen_spk',
        'judul_dokumen_spk',
        'nama_custoer',
        'alamat_customer',
        'status_aktif_dokumen',
    ];
}
