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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('ten_admin',100);
            $table->string('email',100)->unique();
            $table->string('mat_khau',100);
            $table->text('avatar')->nullable();
            $table->string('id_chuc_vu',10);
            $table->string('id_nguoi_dung',10);
            $table->string('trang_thai',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
