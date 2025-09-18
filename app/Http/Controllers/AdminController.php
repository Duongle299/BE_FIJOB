<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Nguoidung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $check = Admin::join('nguoidungs', 'admins.id_nguoi_dung', '=', 'nguoidungs.id')
            ->where('nguoidungs.email', $request->email)
            ->where('nguoidungs.mat_khau', $request->mat_khau)
            ->first();

        if (!$check) {
            return response()->json([
                'status' => 0,
                'message' => "Sai tài khoản hoặc mật khẩu"
            ]);
        }else{}
            return response()->json([
                "status" => 1,
                "message" => "đăng nhập thành công",
                'token' => $check->createToken('auth_admin')->plainTextToken,
            ]);
    }
    public function checktoken(Request $request)
    {
        $user_login = Auth::guard('sanctum')->user();
        if($user_login) {
            return response()->json([
                'status'    => 1,
                'ho_ten'    => $user_login->ten_admin
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        }
    }
    public function getdataungvien(){
        $data = Nguoidung::join('ungviens','nguoidungs.id','ungviens.ma_nguoi_dung')
                        ->select('ungviens.id','ungviens.ten_ung_vien','nguoidungs.email','ungviens.so_dien_thoai','ungviens.gioi_tinh','ungviens.ngay_sinh','ungviens.dia_chi','nguoidungs.avatar','nguoidungs.trang_thai')
                        ->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
