<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hosoungvien extends Model
{
    protected $table = 'hosoungviens';
    protected $fillable = [
        'id_ung_vien',
        'ho_ten',
        'email', // <-- Mới
        'so_dien_thoai', // <-- Mới
        'nam_sinh', // <-- Mới
        'gioi_tinh', // <-- Mới
        'dia_chi', // <-- Mới
        'so_cmnd_cccd', // <-- Mới
        'hon_nhan',
        'trinh_do_hoc_van',
        'cap_bac_mong_muon',
        'ky_nang',
        'vi_tri_ung_tuyen',
        'nganh_nghe',
        'kinh_nghiem',
        'trang_thai',
        'cv_path',
        'id_nhatuyendung',
        'muc_luong_mong_muon', // <-- Mới
    ];
}
