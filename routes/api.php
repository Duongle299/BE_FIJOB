<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BaivietController;
use App\Http\Controllers\CVcontroller;
use App\Http\Controllers\NhatuyendungController;
use App\Http\Controllers\UngvienController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API Admin
Route::post('admin/dang_nhap',[AdminController::class,'login']);
Route::get('admin/check-token',[AdminController::class,'checktoken']);
Route::get('admin/logout',[AdminController::class,'logout']);


Route::get('admin/ung_vien',[AdminController::class,'getdataungvien']);
Route::get('admin/nha_tuyen_dung',[AdminController::class,'getdatanhatuyendung']);
Route::post('admin/ung_vien/khoa',[AdminController::class,'khoaTaikhoanungvien'])->middleware('checkadmin');
Route::post('admin/nha_tuyen_dung/khoa',[AdminController::class,'khoaTaikhoannhatuyendung'])->middleware('checkadmin');

Route::get('admin/profile',[AdminController::class,'profile'])->middleware('checkadmin');
Route::post('admin/update_profile',[AdminController::class,'upprofile'])->middleware('checkadmin');
Route::post('admin/update_matkhau',[AdminController::class,'uppassword'])->middleware('checkadmin');


Route::get('admin/get_bai_viet',[BaivietController::class,'getbaiviet']);
Route::post('admin/create_bai_viet',[BaivietController::class,'createbaiviet']);
Route::post('admin/update_bai_viet',[BaivietController::class,'updatebaiviet']);
Route::post('admin/delete_bai_viet',[BaivietController::class,'deletebaiviet']);

Route::get('admin/get-bai-tuyen-dung',[AdminController::class,'getTinTuyenDung'])->middleware('checkadmin');
Route::get('admin/dem-tin-tuyen-dung',[AdminController::class,'dembaituyendung']);
Route::post('admin/duyet-tin-tuyen-dung',[AdminController::class,'duyetTinTuyenDung'])->middleware('checkadmin');
Route::post('admin/Reject-tin-tuyen-dung',[AdminController::class,'RejectTinTuyenDung'])->middleware('checkadmin');


// API ung vien
Route::post('ung_vien/signup',[UngvienController::class,'signup']);
Route::post('ung_vien/login',[UngvienController::class,'login']);
Route::get('ung_vien/check-token',[UngvienController::class,'checkToken']);
Route::get('ung_vien/logout',[UngvienController::class,'logout']);

Route::get('ung_vien/profile',[UngvienController::class,'profile'])->middleware('checkclient');
Route::post('ung_vien/update_profile',[UngvienController::class,'upprofile'])->middleware('checkclient');
Route::post('ung_vien/update_matkhau',[UngvienController::class,'uppassword'])->middleware('checkclient');

Route::get('ung_vien/get_tin_tuyen_dung',[UngvienController::class,'getTinTuyenDung']);
Route::get('ung_vien/get_linh_vuc',[UngvienController::class,'getLinhvuc']);
Route::get('ung_vien/trang_chu/get_tin_tuyen_dung',[UngvienController::class,'gettrangchu']);
Route::get('ung_vien/trang_chu/dem-tin-tuyen-dung',[UngvienController::class,'demtintuyendung']);

Route::post('ung_vien/upload_cv',[CVcontroller::class,'UploadCV']);
Route::post('ung_vien/ung-tuyen',[CVcontroller::class,'ungtuyen']);
Route::get('ung_vien/get-data-cv',[UngvienController::class,'UploadCV'])->middleware('checkclient');
Route::post('ung_vien/delete-ho-so',[UngvienController::class,'deletehoso'])->middleware('checkclient');






// API nhà tuyển dụng
Route::post('nha_tuyen_dung/signup',[NhatuyendungController::class,'signup']);
Route::post('nha_tuyen_dung/login',[NhatuyendungController::class,'login']);
Route::get('nha_tuyen_dung/check-token',[NhatuyendungController::class,'checkToken']);
Route::get('nha_tuyen_dung/logout',[NhatuyendungController::class,'logout']);


Route::get('nha_tuyen_dung/profile',[NhatuyendungController::class,'profile'])->middleware('checkemployer');
Route::post('nha_tuyen_dung/update_profile',[NhatuyendungController::class,'upprofile'])->middleware('checkemployer');
Route::post('nha_tuyen_dung/update_matkhau',[NhatuyendungController::class,'uppassword'])->middleware('checkclient');

Route::get('nha_tuyen_dung/get-bai-tuyen-dung',[NhatuyendungController::class,'getbaituyendung'])->middleware('checkemployer');
Route::post('nha_tuyen_dung/create-bai-tuyen-dung',[NhatuyendungController::class,'createbaituyendung'])->middleware('checkemployer');
Route::post('nha_tuyen_dung/update-bai-tuyen-dung',[NhatuyendungController::class,'updatebaituyendung'])->middleware('checkemployer');
Route::post('nha_tuyen_dung/delete-bai-tuyen-dung',[NhatuyendungController::class,'deletebaituyendung'])->middleware('checkemployer');

Route::get('nha_tuyen_dung/get-data-ung-vien',[NhatuyendungController::class,'getdataungvien'])->middleware('checkemployer');
Route::post('nha_tuyen_dung/reject-ho-so',[NhatuyendungController::class,'rejecthoso'])->middleware('checkemployer');







