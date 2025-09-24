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
        Schema::create('hosoungviens', function (Blueprint $table) {
            $table->id();
            $table->string('id_ung_vien');
            $table->string('ho_ten');
            $table->string('hon_nhan');
            $table->string('trinh_do_hoc_van');
            $table->string('cap_bac_mong_muon');
            $table->string('ky_nang');
            $table->string('vi_tri_ung_tuyen');
            $table->string('nganh_nghe');
            $table->string('kinh_nghiem');
            $table->integer('trang_thai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosoungviens');
    }
};
