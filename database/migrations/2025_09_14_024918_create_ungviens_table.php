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
        Schema::create('ungviens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_ung_vien',10)->unique();
            $table->string('ten_ung_vien',100);
            $table->date('ngay_sinh');
            $table->string('gioi_tinh',10);
            $table->string('so_dien_thoai',15);
            $table->string('dia_chi',200);
            $table->string('ma_nguoi_dung',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ungviens');
    }
};
