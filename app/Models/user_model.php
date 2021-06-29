<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class user_model extends Model
{
    protected $table = 'user';
    protected $primaryKey  = 'id_user';
    protected $fillable = [
        'email',
        'username',
        'password',
        'status_aktif',
    ];
}
