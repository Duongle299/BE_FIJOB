<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BaivietController;
use App\Http\Controllers\UngvienController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API Admin
Route::post('admin/dang_nhap',[AdminController::class,'login']);
Route::get('admin/check-token',[AdminController::class,'checktoken']);

Route::get('admin/ung_vien',[AdminController::class,'getdataungvien']);
Route::get('admin/nha_tuyen_dung',[AdminController::class,'getdatanhatuyendung']);
Route::post('admin/ung_vien/khoa',[AdminController::class,'khoaTaikhoanungvien'])->middleware('checkadmin');
Route::post('admin/nha_tuyen_dung/khoa',[AdminController::class,'khoaTaikhoannhatuyendung'])->middleware('checkadmin');




Route::get('admin/get_bai_viet',[BaivietController::class,'getbaiviet']);
Route::post('admin/create_bai_viet',[BaivietController::class,'createbaiviet']);
Route::post('admin/update_bai_viet',[BaivietController::class,'updatebaiviet']);
Route::post('admin/delete_bai_viet',[BaivietController::class,'deletebaiviet']);



// API ung vien
Route::post('ung_vien/signup',[UngvienController::class,'signup']);
Route::post('ung_vien/login',[UngvienController::class,'login']);
Route::get('ung_vien/check-token',[UngvienController::class,'checkToken']);

Route::get('ung_vien/profile',[UngvienController::class,'profile'])->middleware('checkclient');
Route::post('ung_vien/update_profile',[UngvienController::class,'upprofile'])->middleware('checkclient');




