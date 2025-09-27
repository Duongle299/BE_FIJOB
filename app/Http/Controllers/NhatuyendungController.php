<?php

namespace App\Http\Controllers;

use App\Models\Nhatuyendung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NhatuyendungController extends Controller
{
    public function login(Request $request)
    {
         $check = Nhatuyendung::where('email', $request->email)
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
                    'ho_ten'    => $user_login->ten_cong_ty,
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
            if( $request->id_nguoi_dung == 3){
                Nhatuyendung::create([
                        'ten_cong_ty'  => $request->ten_cong_ty,
                        'email'         => $request->email,
                        'mat_khau'      => $request->mat_khau,
                        'id_nguoi_dung'   => $request->id_nguoi_dung,
                    ]);
                    return response()->json([
                        'status' => true,
                        'message' => 'Đăng ký tài khoản nhà tuyển dụng thành công'
                    ]);
            }else{
                 return response()->json([
                        'status' => false,
                        'message' => 'Đăng ký tài khoản nhà tuyển dụng thất bại'
                    ]);
            }
    }
    public function profile()
    {
        $user_login = Auth::guard('sanctum')->user();
        if($user_login){
            $nhatuyendung = Nhatuyendung::where('nhatuyendungs.id', $user_login->id)->first();
            return response()->json([
                'status' => true,
                'data'   => $nhatuyendung
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
        $data = Nhatuyendung::find($user->id);
        if($data){
            $data->update([
                'ten_cong_ty'    => $request->ten_cong_ty,
                'email'          => $request->email,
                'avatar'         => $request->avatar,
                'mo_ta'          => $request->mo_ta,
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
