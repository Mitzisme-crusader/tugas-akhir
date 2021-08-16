<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokumenSpk_model extends Model
{
    protected $table = 'dokumenSpk';
    protected $primaryKey  = 'id_dokumen';
    protected $fillable = [
        'id_customer',
        'nama_customer',
        'nama_perusahaan_customer',
        'negara_customer',
        'status_aktif_customer',
    ];
}
