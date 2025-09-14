<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucvuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chucvus')->delete();
        DB::table('chucvus')->truncate();
        DB::table('chucvus')->insert([
            [
                'ma_chuc_vu' => 'CV001',
                'ten_chuc_vu' => 'Quản trị viên',
            ],
            [
                'ma_chuc_vu' => 'CV002',
                'ten_chuc_vu' => 'Kế toán',
            ],
            [
                'ma_chuc_vu' => 'CV003',
                'ten_chuc_vu' => 'Giám đốc',
            ],
        ]);
    }
}
