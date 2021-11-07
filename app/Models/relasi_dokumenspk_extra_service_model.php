<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class relasi_dokumenspk_extra_service_model extends Model
{
    protected $table = 'relasi_dokumenspk_extra_service';
    protected $primaryKey  = 'id_relasi_dokumenspk_extra_service';
    protected $fillable = [
        'id_dokumen_spk',
        'nama_extra_service',
        'harga_extra_service',
        'container'
    ];
}
