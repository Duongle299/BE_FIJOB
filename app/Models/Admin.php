<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'admins';
    protected $fillable = [
        'ten_admin',
        'email',
        'mat_khau',
        'avatar',
        'ma_chuc_vu',
        'ma_nguoi_dung',
        'trang_thai'
    ];
}
