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
                'ten_admin' => 'Admin A',
                'email' => 'admina@example.com',
                'mat_khau' => '123456',
                'avatar' => 'https://scr.vn/wp-content/uploads/2020/07/h%C3%ACnh-%C4%91%E1%BA%A1i-di%E1%BB%87n-cute-cho-con-trai.jpg',
                'id_chuc_vu' => 'CV001',
                'id_nguoi_dung' => '1',
                'trang_thai' => '1',
            ],
        ]);
    }
}
