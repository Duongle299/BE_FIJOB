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
             // Thêm cột 'cv_path' kiểu string để lưu đường dẫn file CV.
            // Sử dụng nullable() vì file CV có thể không phải lúc nào cũng được tải lên (tùy logic app của bạn).
            // Bạn có thể tùy chỉnh độ dài string và vị trí cột (ví dụ: after('email')).
            $table->string('cv_path', 255)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hosoungviens', function (Blueprint $table) {
            $table->dropColumn('cv_path');
        });
    }
};
