<?php

namespace App\Http\Controllers;

use App\Models\Baituyendung;
use App\Models\Nhatuyendung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NhatuyendungController extends Controller
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
            Nhatuyendung::create([
                        'ten_cong_ty'  => $request->ten_cong_ty,
                        'email'         => $request->email,
                        'mat_khau'      => $request->mat_khau,
                        'id_nguoi_dung'   => 3,
                        'trang_thai'    => 1,
                    ]);
                    return response()->json([
                        'status' => true,
                        'message' => 'Đăng ký tài khoản nhà tuyển dụng thành công'
                    ]);
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
    public function uppassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $data = Nhatuyendung::where('id' , $user->id)
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
    public function getbaituyendung(){
        $user_login = Auth::guard('sanctum')->user();
        $data = Baituyendung::join('linhvucs','baituyendungs.ma_linh_vuc','linhvucs.id')
        ->where('ma_nha_tuyen_dung', $user_login->id)
        ->select('baituyendungs.*','linhvucs.ten_linh_vuc')
        ->orderBy('baituyendungs.id', 'asc')
        ->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function createbaituyendung(Request $request){
        $user_login = Auth::guard('sanctum')->user();
         if (!$user_login) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        }else{
            Baituyendung::create([
                'ma_bai_tuyen_dung' => $request->ma_bai_tuyen_dung,
                'tieu_de'           => $request->tieu_de,
                'hinh_anh'          => $request->hinh_anh,
                'mo_ta_cong_viec'   => $request->mo_ta_cong_viec,
                'muc_luong'         => $request->muc_luong,
                'dia_diem'          => $request->dia_diem,
                'yeu_cau'           => $request->yeu_cau,
                'ma_nha_tuyen_dung' => $user_login->id,
                'ngay_dang'         => $request->ngay_dang,
                'han_nop'           => $request->han_nop,
                'trang_thai'        => 0,
                'ma_linh_vuc'       => $request->ma_linh_vuc,
        ]);
            return response()->json([
                'status' => true,
                'message' => 'Thêm mới bài tuyển dụng thành công',
            ]);
        }
    }
    public function updatebaituyendung(Request $request){
        $user_login = Auth::guard('sanctum')->user();
         if (!$user_login) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        }else{
            Baituyendung::where('id',$request->id)->update([
                'ma_bai_tuyen_dung' => $request->ma_bai_tuyen_dung,
                'tieu_de'           => $request->tieu_de,
                'hinh_anh'          => $request->hinh_anh,
                'mo_ta_cong_viec'   => $request->mo_ta_cong_viec,
                'muc_luong'         => $request->muc_luong,
                'dia_diem'          => $request->dia_diem,
                'yeu_cau'           => $request->yeu_cau,
                'ngay_dang'         => $request->ngay_dang,
                'han_nop'           => $request->han_nop,
                'ma_linh_vuc'       => $request->ma_linh_vuc,
        ]);
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật bài tuyển dụng thành công',
            ]);
        }
    }
    public function deletebaituyendung(Request $request){
        $user_login = Auth::guard('sanctum')->user();
         if (!$user_login) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        }else{
            Baituyendung::where('id',$request->id)->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Xóa bài viết thành công',
            ]);
        }


    }
}
