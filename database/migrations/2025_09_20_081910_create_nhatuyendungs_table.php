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
        Schema::create('nhatuyendungs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_cong_ty');
            $table->string('email');
            $table->string('mat_khau');
            $table->string('avatar')->nullable();
            $table->string('so_dien_thoai');
            $table->string('dia_chi');
            $table->string('linh_vuc');
            $table->string('mo_ta');
            $table->string('website');
            $table->integer('id_nguoi_dung');
            $table->string('trang_thai',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhatuyendungs');
    }
};
