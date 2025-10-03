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
        Schema::table('hosoungviens', function (Blueprint $table) {
            // Thông tin liên hệ
           $table->string('email', 150)->unique()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hosoungviens', function (Blueprint $table) {
            $table->dropColumn([
                'email',
            ]);
        });
    }
};
