<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baiviet extends Model
{
    protected $table = 'baiviets';
    protected $fillable = [
        'ma_bai_viet',
        'ma_danh_muc',
        'tieu_de',
        'noi_dung',
        'hinh_anh',
        'ngay_dang',
        'trang_thai',
    ];
}
