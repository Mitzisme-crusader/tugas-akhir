<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jurnal_umum_model extends Model
{
    protected $table = 'jurnal_umum';
    protected $primaryKey  = 'id_jurnal_umum';
    protected $fillable = [
        'nama_rekening',
        'nomor_rekening',
        'nomor_COA',
        'keterangan_tagihan',
        'total_debit',
        'total_kredit',
        'hutang',
        'piutang',
        'total_rekening',
        'status_aktif',
    ];
}
