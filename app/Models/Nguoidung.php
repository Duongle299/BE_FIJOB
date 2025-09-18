<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Nguoidung extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;
    protected $table = 'nguoidungs';
    protected $fillable = [
        'email',
        'mat_khau',
        'avatar',
        'vai_tro',
        'trang_thai'
    ];
}
