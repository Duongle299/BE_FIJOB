<?php

namespace App\Http\Controllers;

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
        $data = $request->all();
        Baiviet::create([
            
        ]);
        return response()->json([
            'message' => 'Thêm mới bài viết thành công',
            'data' => $data
        ],201);

    }
    public function updatebaiviet(Request $request,$id){

    }
    public function deletebaiviet($id){

    }
}
