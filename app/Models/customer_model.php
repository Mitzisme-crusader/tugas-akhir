<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer_model extends Model
{
    protected $table = 'customer';
    protected $primaryKey  = 'id_customer';
    protected $fillable = [
        'nama',
        'email',
        'npwp',
        'alamat_pajak',
        'kode_pos',
        'negara',
        'nomor_telepon',
        'status_aktif'
    ];
}
