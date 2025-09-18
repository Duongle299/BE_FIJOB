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
        Schema::create('nguoidungs', function (Blueprint $table) {
            $table->id();
            $table->string('email',100)->unique();
            $table->string('mat_khau',100);
            $table->text('avatar')->nullable();
            $table->string('vai_tro',100);
            $table->integer('trang_thai')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoidungs');
    }
};
