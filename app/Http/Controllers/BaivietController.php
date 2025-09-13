<?php

namespace App\Http\Controllers;

use App\Http\Requests\CapnhatbaivietRequest;
use App\Http\Requests\ThemmoibaivietRequest;
use App\Models\Baiviet;
use Illuminate\Http\Request;

class BaivietController extends Controller
{
    public function getbaiviet(){
        $data = Baiviet::join('danhmucs','baiviets.ma_danh_muc','danhmucs.ma_danh_muc')
        ->select('danhmucs.ten_danh_muc','baiviets.tieu_de','baiviets.noi_dung','baiviets.hinh_anh','baiviets.ngay_dang')
        ->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function createbaiviet(ThemmoibaivietRequest $request){
        Baiviet::create([
                'ma_bai_viet'   => $request->ma_bai_viet,
                'ma_danh_muc'   => $request->ma_danh_muc,
                'tieu_de'       => $request->tieu_de,
                'noi_dung'      => $request->noi_dung,
                'hinh_anh'      => $request->hinh_anh,
                'ngay_dang'     => $request->ngay_dang,
                'trang_thai'    => '0',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới bài viết thành công',
        ]);

    }
    public function updatebaiviet(CapnhatbaivietRequest $request){
            Baiviet::find($request->ma_bai_viet)->update([
                'ma_danh_muc'   => $request->ma_danh_muc,
                'tieu_de'       => $request->tieu_de,
                'noi_dung'      => $request->noi_dung,
                'hinh_anh'      => $request->hinh_anh,
                'ngay_dang'     => $request->ngay_dang,
                'trang_thai'    => '0',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'cập nhật bài viết thành công',
        ]);
    }
    public function deletebaiviet($id){

    }
}
