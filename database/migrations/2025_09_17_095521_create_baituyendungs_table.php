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
        Schema::create('baituyendungs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_bai_tuyen_dung', 50)->unique();
            $table->string('tieu_de');
            $table->string('hinh_anh');
            $table->text('mo_ta_cong_viec');
            $table->text('yeu_cau');
            $table->string('muc_luong');
            $table->string('dia_diem');
            $table->integer('trang_thai')->default(0);
            $table->date('ngay_dang');
            $table->date('han_nop');
            $table->string('ma_nha_tuyen_dung',50);
            $table->string('ma_linh_vuc',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baituyendungs');
    }
};
