<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ungvien extends Model
{
    protected $table = 'ungviens';
    protected $fillable = [
        'ma_ung_vien',
        'ten_ung_vien',
        'ngay_sinh',
        'gioi_tinh',
        'so_dien_thoai',
        'dia_chi',
        'ma_nguoi_dung'
    ];
}
