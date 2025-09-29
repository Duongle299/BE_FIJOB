<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Baituyendung;
use App\Models\Nguoidung;
use App\Models\Nhatuyendung;
use App\Models\ungvien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Guard;

class AdminController extends Controller
{
    public function logout()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            DB::table('personal_access_tokens')
                ->where('id', $user->currentAccessToken()->id)
                ->delete();
            return response()->json([
                'status'  => 1,
                'message' => "Đăng xuất thành công",
            ]);
        } else {
            return response()->json([
                'status'  => 0,
                'message' => "Có lỗi xảy ra",
            ]);
        }
    }
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
        // $data = Nhatuyendung::join('baituyendungs','nhatuyendungs.id','baituyendungs.ma_nha_tuyen_dung')
        //                     ->join('linhvucs','linhvucs.ma_linh_vuc','baituyendungs.ma_linh_vuc')
        //                     ->select('nhatuyendungs.*','linhvucs.ten_linh_vuc')
        //                     ->get();
        $data = Nhatuyendung::all();
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
    public function profile()
    {
        $user_login = Auth::guard('sanctum')->user();
        if($user_login){
            $admin = Admin::where('admins.id', $user_login->id)
                          ->join('chucvus','admins.id_chuc_vu','chucvus.ma_chuc_vu')
                          ->select('admins.*','chucvus.ten_chuc_vu')
                          ->first();
            return response()->json([
                'status' => true,
                'data'   => $admin
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
        $data = Admin::find($user->id);
        if($data){
            $data->update([
                'ten_admin'    => $request->ten_admin,
                'email'        => $request->email,
                'avatar'       => $request->avatar,
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
    public function uppassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $data = Admin::where('id' , $user->id)
                        ->where('mat_khau' , $request->old_mat_khau)
                        ->first();
        if($data){
            $data->update([
                'mat_khau' => $request->mat_khau,
            ]);
            return response()->json([
                'status' => 1,
                'message'   => 'Đổi mật khẩu thành công'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message'   => 'Mật khẩu cũ không đúng'
            ]);
        }
    }
    public function getTinTuyenDung()
    {
        $user_login = Auth::guard('sanctum')->user();
        if(!$user_login || !$user_login->id){
            return response()->json([
                'status'    => false,
                'message'   => 'cần đăng nhập tài khoản'
            ]);
        }
        $data = Baituyendung::join('nhatuyendungs','baituyendungs.ma_nha_tuyen_dung','nhatuyendungs.id')
                            ->select('baituyendungs.*','nhatuyendungs.ten_cong_ty')
                            ->where('baituyendungs.trang_thai',0)
                            ->get();
        return response()->json([
                'status' => true,
                'data'   => $data
            ]);
    }
     public function duyetTinTuyenDung(Request $request)
    {
        $user_login = Auth::guard('sanctum')->user();
        if(!$user_login || !$user_login->id){
            return response()->json([
                'status'    => false,
                'message'   => 'cần đăng nhập để duyệt bài tuyển dụng'
            ]);
        }
        $data = Baituyendung::find($request->id);
        if(!$data){
                return response()->json([
                'status'    => false,
                'message'   => 'không tìm thấy bài tuyển dụng'
            ]);
        }
        if($data->trang_thai == 0){
            $data->trang_thai = 1;
        }
        $data->save();
        return response()->json([
                'status'    => true,
                'message'   => 'duyệt bài tuyển dụng thành công'
            ]);
    }
     public function RejectTinTuyenDung(Request $request)
    {
        $user_login = Auth::guard('sanctum')->user();
        if(!$user_login || !$user_login->id){
            return response()->json([
                'status'    => false,
                'message'   => 'cần đăng nhập để duyệt bài tuyển dụng'
            ]);
        }
        $data = Baituyendung::find($request->id);
        if(!$data){
                return response()->json([
                'status'    => false,
                'message'   => 'không tìm thấy bài tuyển dụng'
            ]);
        }
        if($data->trang_thai == 0){
            $data->trang_thai = 2;
        }
        $data->save();
        return response()->json([
                'status'    => true,
                'message'   => 'Đã từ chối bài tuyển dụng'
            ]);

    }
}
