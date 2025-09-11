<?php

use App\Http\Controllers\BaivietController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API Admin
Route::get('admin/get_bai_viet',[BaivietController::class,'getbaiviet']);
Route::post('admin/create_bai_viet',[BaivietController::class,'createbaiviet']);
Route::put('admin/update_bai_viet/{id}',[BaivietController::class,'updatebaiviet']);
Route::delete('admin/delete_bai_viet/{id}',[BaivietController::class,'deletebaiviet']);
