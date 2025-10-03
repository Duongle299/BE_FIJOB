<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Baituyendung;
use App\Models\Linhvuc;
use App\Models\Nguoidung;
use App\Models\Nhatuyendung;
use App\Models\ungvien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UngvienController extends Controller
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
    public function login(LoginRequest $request)
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
                ungvien::create([
                        'ten_ung_vien'  => $request->ten_ung_vien,
                        'email'         => $request->email,
                        'mat_khau'      => $request->mat_khau,
                        'ma_nguoi_dung'    => 2,
                        'trang_thai'    => 1,
                    ]);
                    return response()->json([
                        'status' => 1,
                        'message' => 'Đăng ký tài khoản ứng viên thành công'
                    ]);
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
    public function uppassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $data = ungvien::where('id' , $user->id)
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
        $user = Auth::guard('sanctum')->user();
        $data = Baituyendung::join('nhatuyendungs','baituyendungs.ma_nha_tuyen_dung','nhatuyendungs.id')
                            ->join('linhvucs','baituyendungs.ma_linh_vuc','linhvucs.id')
                            ->select('baituyendungs.*','nhatuyendungs.ten_cong_ty','linhvucs.ten_linh_vuc')
                            ->where('baituyendungs.trang_thai',1)
                            ->get();
        return response()->json([
                'status' => true,
                'data'   => $data
            ]);

    }
    public function gettrangchu()
    {
        $user = Auth::guard('sanctum')->user();
        $data = Baituyendung::join('nhatuyendungs','baituyendungs.ma_nha_tuyen_dung','nhatuyendungs.id')
                            ->join('linhvucs','baituyendungs.ma_linh_vuc','linhvucs.id')
                            ->select('baituyendungs.*','nhatuyendungs.ten_cong_ty','linhvucs.ten_linh_vuc')
                            ->orderBy('created_at', 'desc')
                            ->where('baituyendungs.trang_thai',1)
                            ->take(3)
                            ->get();
        return response()->json([
                'status' => true,
                'data'   => $data
            ]);

    }
    public function demtintuyendung()
    {
        $user = Auth::guard('sanctum')->user();
        $data = Baituyendung::join('nhatuyendungs','baituyendungs.ma_nha_tuyen_dung','nhatuyendungs.id')
                            ->select('nhatuyendungs.ten_cong_ty','nhatuyendungs.avatar',
                             DB::raw('COUNT(baituyendungs.ma_nha_tuyen_dung) as so_bai_tuyen_dung'))
                            ->groupBy('nhatuyendungs.ten_cong_ty','nhatuyendungs.avatar')
                            ->orderByDesc('so_bai_tuyen_dung')
                            ->where('baituyendungs.trang_thai',1)
                            ->take(3)
                            ->get();
        return response()->json([
                'status' => true,
                'data'   => $data
            ]);

    }
    public function getLinhvuc()
    {
        $user = Auth::guard('sanctum')->user();
        $data = Linhvuc::all();
        return response()->json([
                'status' => true,
                'data'   => $data
            ]);

    }


}
