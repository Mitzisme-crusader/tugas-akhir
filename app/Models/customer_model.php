<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer_model extends Model
{
    protected $table = 'customer';
    protected $primaryKey  = 'id_customer';
    protected $fillable = [
        'nama_customer',
        'email_customer',
        'nama_perusahaan_customer',
        'alamat_customer_customer',
        'provinsi_customer',
        'npwp_customer',
        'alamat_pajak_customer',
        'kode_pos_customer',
        'negara_customer',
        'nomor_telepon_customer',
        'status_aktif_customer'
    ];
}
