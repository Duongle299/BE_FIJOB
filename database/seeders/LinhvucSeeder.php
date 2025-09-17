<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinhvucSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('linhvucs')->delete();
        DB::table('linhvucs')->truncate();
        DB::table('linhvucs')->insert([
            [
                'ma_linh_vuc' => 'LV001',
                'ten_linh_vuc' => 'Giáo dục'
            ],
            [
                'ma_linh_vuc' => 'LV002',
                'ten_linh_vuc' => 'Công nghệ thông tin'
            ],
            [
                'ma_linh_vuc' => 'LV003',
                'ten_linh_vuc' => 'Y tế'
            ],
            [
                'ma_linh_vuc' => 'LV004',
                'ten_linh_vuc' => 'Kinh doanh'
            ],
        ]);
    }
}
