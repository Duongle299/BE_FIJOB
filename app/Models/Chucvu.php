<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chucvu extends Model
{
    protected $table = 'chucvus';
    protected $fillable = [
        'ma_chuc_vu',
        'ten_chuc_vu'
    ];
}
