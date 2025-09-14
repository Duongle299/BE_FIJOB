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
                'ma_nguoi_dung' => 'ND001',
                'email' => 'admin001@gmail.com',
                'mat_khau' => '123456',
                'avatar' => 'https://tse1.mm.bing.net/th/id/OIP.iZBIqwzEVRVABv25Z2lkswHaHa?pid=Api&P=0&h=220',
                'vai_tro' => 'Admin',
                'trang_thai' => 1
            ],
            [
                'ma_nguoi_dung' => 'ND002',
                'email' => 'nguyenvana@gmail.com',
                'mat_khau' => '123456',
                'avatar' => 'https://cellphones.com.vn/sforum/wp-content/uploads/2024/01/avartar-anime-74.jpg',
                'vai_tro' => 'Ứng viên',
                'trang_thai' => 1
            ],
            [
                'ma_nguoi_dung' => 'ND003',
                'email' => 'congtya@gmail.com',
                'mat_khau' => '123456',
                'avatar' => 'https://sudospaces.com/hoaphat-com-vn/uploads/logo-moi-2-e1509520466200.jpg',
                'vai_tro' => 'Nhà tuyển dụng',
                'trang_thai' => 1
            ],
        ]);
    }
}
