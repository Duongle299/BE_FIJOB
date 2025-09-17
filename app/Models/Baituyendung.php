<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baituyendung extends Model
{
    protected $table = 'baituyendungs';
    protected $fillable = [
        'ma_bai_tuyen_dung',
        'tieu_de',
        'hinh_anh',
        'mo_ta_cong_viec',
        'yeu_cau',
        'ma_danh_muc',
        'ma_cong_ty',
        'ma_nguoi_dung',
        'ngay_dang',
        'han_nop',
        'trang_thai',
        'ma_linh_vuc'
    ];
}
