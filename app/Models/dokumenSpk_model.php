<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokumenSpk_model extends Model
{
    protected $table = 'dokumen_spk';
    protected $primaryKey  = 'id_dokumen_spk';
    protected $fillable = [
        'id_customer',
        'judul_dokumen',
        'id_service',
        'nama_customer',
        'nama_perusahaan_customer',
        'negara_customer',
        'status_aktif_dokumen',
    ];
}
