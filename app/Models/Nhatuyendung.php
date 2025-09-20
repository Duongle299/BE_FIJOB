<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nhatuyendung extends Model
{
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
