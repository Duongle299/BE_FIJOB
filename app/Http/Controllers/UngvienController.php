<?php

namespace App\Http\Controllers;

use App\Models\Nguoidung;
use App\Models\ungvien;
use Illuminate\Http\Request;

class UngvienController extends Controller
{
    public function signup(Request $request)
    {
        Nguoidung::create([
            'email'         => $request->email,
            'mat_khau'      => $request->mat_khau,
            'vai_tro'       => $request->vai_tro,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Đăng ký tài khoản thành công'
        ]);
    }
}
