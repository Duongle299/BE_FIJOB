<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Nhatuyendung extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $table = 'nhatuyendungs';
    protected $fillable = [
        'ten_cong_ty',
        'email',
        'mat_khau',
        'avatar',
        'so_dien_thoai',
        'dia_chi',
        'linh_vuc',
        'mo_ta',
        'website',
        'id_nguoi_dung',
        'trang_thai'
    ];
}
