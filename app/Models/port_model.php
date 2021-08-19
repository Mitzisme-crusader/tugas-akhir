<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class port_model extends Model
{
    protected $table = 'port';
    protected $primaryKey  = 'id_port';
    protected $fillable = [
        'nama_port',
        'alamat_port',
        'negara_port',
    ];
}
