<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Linhvuc extends Model
{
    protected $table = 'linhvucs';
    protected $fillable = [
        'ma_linh_vuc',
        'ten_linh_vuc'
    ];
}
