<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class service_model extends Model
{
    protected $table = 'service';
    protected $primaryKey  = 'id_service';
    protected $fillable = [
        'nama_service',
        'deskripsi_service',
        'biaya_service',
        'detail_service',
        'status_aktif',
    ];
}
