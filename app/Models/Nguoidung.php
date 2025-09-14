<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nguoidung extends Model
{
    protected $table = 'nguoidungs';
    protected $fillable = [
        'ma_nguoi_dung',
        'email',
        'mat_khau',
        'avatar',
        'vai_tro',
        'trang_thai'
    ];
}
