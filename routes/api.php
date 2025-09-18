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


Route::get('admin/get_bai_viet',[BaivietController::class,'getbaiviet']);
Route::post('admin/create_bai_viet',[BaivietController::class,'createbaiviet']);
Route::post('admin/update_bai_viet',[BaivietController::class,'updatebaiviet']);
Route::post('admin/delete_bai_viet',[BaivietController::class,'deletebaiviet']);



// API ung vien
Route::post('ung_vien/signup',[UngvienController::class,'signup']);
