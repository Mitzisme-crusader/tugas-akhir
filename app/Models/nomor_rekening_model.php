<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nomor_rekening_model extends Model
{
    protected $table = 'dokumen_so';
    protected $primaryKey  = 'id_dokumen_so';
    protected $fillable = [
        'nomor_rekening',
        'nama_rekening',
        'id_COA',
        'total_rekening',
        'status_aktif_rekening',
    ];
}
