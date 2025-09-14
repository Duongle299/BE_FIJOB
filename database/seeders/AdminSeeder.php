<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->delete();
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            [
                'ma_admin' => 'AD001',
                'ten_admin' => 'Admin A',
                'ma_chuc_vu' => 'CV001',
                'ma_nguoi_dung' => 'ND001',
            ],
        ]);
    }
}
