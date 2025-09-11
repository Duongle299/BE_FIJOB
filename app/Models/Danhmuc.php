<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Danhmuc extends Model
{
    protected $table = 'danhmucs';
    protected $fillable = [
        'ma_danh_muc',
        'ten_danh_muc'
    ];
}
