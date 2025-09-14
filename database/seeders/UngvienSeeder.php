<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UngvienSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('ungviens')->delete();
        DB::table('ungviens')->truncate();
        DB::table('ungviens')->insert([
            [
                'ma_ung_vien' => 'UV001',
                'ten_ung_vien' => 'Nguyen Van A',
                'ngay_sinh' => '1990-01-01',
                'gioi_tinh' => 'Nam',
                'so_dien_thoai' => '0123456789',
                'dia_chi' => 'Ha Noi',
                'ma_nguoi_dung' => 'ND002',
            ],
        ]);
    }
}
