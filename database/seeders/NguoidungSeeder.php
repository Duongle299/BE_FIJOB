<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NguoidungSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nguoidungs')->delete();
        DB::table('nguoidungs')->truncate();
        DB::table('nguoidungs')->insert([
            [
                'ten_nguoi_dung' => 'Admin',
            ],
            [
                'ten_nguoi_dung' => 'Ứng viên',
            ],
            [
                'ten_nguoi_dung' => 'Nhà tuyển dụng',
            ],
        ]);
    }
}
