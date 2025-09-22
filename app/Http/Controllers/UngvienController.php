<?php

namespace App\Http\Controllers;

use App\Models\Nguoidung;
use App\Models\Nhatuyendung;
use App\Models\ungvien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UngvienController extends Controller
{
    public function login(Request $request)
    {
        $check = ungvien::where('email', $request->email)
            ->where('mat_khau', $request->mat_khau)
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
    public function checkToken()
    {
        $user_login = Auth::guard('sanctum')->user();
            if($user_login) {
                return response()->json([
                    'status'    => 1,
                    'ho_ten'    => $user_login->ten_ung_vien,
                    'avatar'    => $user_login->avatar
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Bạn cần đăng nhập hệ thống!'
                ]);
            }
    }
    public function signup(Request $request)
    {
        if($request->ma_nguoi_dung == 2){
                ungvien::create([
                        'ten_ung_vien'  => $request->ten_ung_vien,
                        'email'         => $request->email,
                        'mat_khau'      => $request->mat_khau,
                        'ma_nguoi_dung'       => $request->ma_nguoi_dung,
                    ]);
                    return response()->json([
                        'status' => 1,
                        'message' => 'Đăng ký tài khoản ứng viên thành công'
                    ]);
        }else
            if( $request->id_nguoi_dung == 3){
                Nhatuyendung::create([
                        'ten_cong_ty'  => $request->ten_cong_ty,
                        'email'         => $request->email,
                        'mat_khau'      => $request->mat_khau,
                        'id_nguoi_dung'       => $request->id_nguoi_dung,
                    ]);
                    return response()->json([
                        'status' => 2,
                        'message_2' => 'Đăng ký tài khoản nhà tuyển dụng thành công'
                    ]);
            }
    }
    public function profile()
    {
        $user_login = Auth::guard('sanctum')->user();
        if($user_login){
            $ungvien = ungvien::where('ungviens.id', $user_login->id)->first();
            return response()->json([
                'status' => true,
                'data'   => $ungvien
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'   => 'bạn cần đăng nhập tài khoản'
            ]);
        }
    }
    public function upprofile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $data = ungvien::find($user->id);
        if($data){
            $data->update([
               'ten_ung_vien'    => $request->ten_ung_vien,
                'email'          => $request->email,
                'avatar'         => $request->avatar,
                'ngay_sinh'      => $request->ngay_sinh,
                'gioi_tinh'      => $request->gioi_tinh,
                'so_dien_thoai'  => $request->so_dien_thoai,
                'dia_chi'        => $request->dia_chi,
            ]);
            return response()->json([
                'status' => true,
                'message'   => 'Cập nhật thông tin thành công'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'   => 'thông tin tài khoản không tồn tại'
            ]);
        }
    }

}
