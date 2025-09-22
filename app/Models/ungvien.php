<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ungvien extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $table = 'ungviens';
    protected $fillable = [
        'ten_ung_vien',
        'email',
        'mat_khau',
        'avatar',
        'ngay_sinh',
        'gioi_tinh',
        'so_dien_thoai',
        'dia_chi',
        'ma_nguoi_dung',
        'trang_thai'
    ];
}
