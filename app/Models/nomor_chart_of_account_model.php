<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nomor_chart_of_account_model extends Model
{
    protected $table = 'nomor_chart_of_account';
    protected $primaryKey  = 'id_COA';
    protected $fillable = [
        'nomor_COA',
        'nama_jenis_COA',
        'total_COA',
        'status_aktif',
    ];
}
