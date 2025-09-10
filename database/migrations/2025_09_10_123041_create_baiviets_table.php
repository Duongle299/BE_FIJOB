<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('baiviets', function (Blueprint $table) {
            $table->id();
            $table->string("ma_bai_viet", 10)->unique();
            $table->string("ma_danh_muc", 10);
            $table->string("tieu_de");
            $table->string("noi_dung");
            $table->string("hinh_anh");
            $table->dateTime("ngay_dang");
            $table->string("trang_thai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baiviets');
    }
};
