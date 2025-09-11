<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhmucSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('danhmucs')->delete();
        DB::table('danhmucs')->truncate();
        DB::table('danhmucs')->insert([
            [
                'ma_danh_muc' => 'DM001',
                'ten_danh_muc' => 'Bí kíp tìm việc'
            ],
            [
                'ma_danh_muc' => 'DM002',
                'ten_danh_muc' => 'Kỹ năng nghề nghiệp'
            ],
            [
                'ma_danh_muc' => 'DM003',
                'ten_danh_muc' => 'Tin tức tuyển dụng'
            ],
            [
                'ma_danh_muc' => 'DM004',
                'ten_danh_muc' => 'Xu hướng việc làm'
            ],
        ]);
    }
}
