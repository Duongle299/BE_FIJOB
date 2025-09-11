<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaivietSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('baiviets')->delete();
        DB::table('baiviets')->truncate();
        DB::table('baiviets')->insert([
            [
                'ma_bai_viet'   => 'BV001',
                'ma_danh_muc'   => 'DM001',
                'tieu_de'       => 'tổng hợp 60 câu hỏi phỏng vấn kế toán theo nghiệp vụ',
                'noi_dung'      => 'các nhân viên kế toán cần chuẩn bị những kiến thức và những chuyên môn nghiệp vụ',
                'hinh_anh'      => 'https://tse4.mm.bing.net/th/id/OIP.xoBIT95p8qffUBcTVe1DcgHaE8?pid=Api&P=0&h=220',
                'ngay_dang'     => '2025-09-04',
                'trang_thai'    => '0',
            ],
        ]);
    }
}
