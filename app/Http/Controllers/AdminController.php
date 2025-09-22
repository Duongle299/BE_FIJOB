<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Nguoidung;
use App\Models\Nhatuyendung;
use App\Models\ungvien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Guard;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $check = Admin::where('email', $request->email)
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
    public function checktoken(Request $request)
    {
        $user_login = Auth::guard('sanctum')->user();
        if($user_login) {
            return response()->json([
                'status'    => 1,
                'ho_ten'    => $user_login->ten_admin,
                'avatar'    => $user_login->avatar
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        }
    }
    public function getdataungvien(){
        $data = ungvien::all();
        return response()->json([
            'data' => $data
        ]);
    }
    public function getdatanhatuyendung(){
        $data = Nhatuyendung::join('baituyendungs','nhatuyendungs.id','baituyendungs.ma_nha_tuyen_dung')
                            ->join('linhvucs','linhvucs.ma_linh_vuc','baituyendungs.ma_linh_vuc')
                            ->select('nhatuyendungs.*','linhvucs.ten_linh_vuc')
                            ->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function khoaTaikhoanungvien(Request $request)
    {
        $user_login = Auth::guard('sanctum')->user();
        if(!$user_login || !$user_login->id){
            return response()->json([
                'status'    => false,
                'message'   => 'cần đăng nhập để để khóa tài khoản'
            ]);
        }
        $data = ungvien::find($request->id);
        if(!$data){
                return response()->json([
                'status'    => false,
                'message'   => 'không tìm thấy ứng viên'
            ]);
        }
        $data->trang_thai = $data->trang_thai == 1 ? 0 : 1;
        $data->save();
         return response()->json([
                'status'    => true,
                'message'   => 'khóa tài khoản thành công'
            ]);

    }
    public function khoaTaikhoannhatuyendung(Request $request)
    {
        $user_login = Auth::guard('sanctum')->user();
        if(!$user_login || !$user_login->id){
            return response()->json([
                'status'    => false,
                'message'   => 'cần đăng nhập để để khóa tài khoản'
            ]);
        }
        $data = Nhatuyendung::find($request->id);
        if(!$data){
                return response()->json([
                'status'    => false,
                'message'   => 'không tìm thấy nhà tuyển dụng'
            ]);
        }
        $data->trang_thai = $data->trang_thai == 1 ? 0 : 1;
        $data->save();
         return response()->json([
                'status'    => true,
                'message'   => 'khóa tài khoản thành công'
            ]);

    }
}
