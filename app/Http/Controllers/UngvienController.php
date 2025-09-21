<?php

namespace App\Http\Controllers;

use App\Models\Nguoidung;
use App\Models\Nhatuyendung;
use App\Models\ungvien;
use Illuminate\Http\Request;

class UngvienController extends Controller
{
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
}
