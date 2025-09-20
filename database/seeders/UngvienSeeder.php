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
                'ten_ung_vien' => 'Nguyen Van A',
                'email' => 'nguyenvana@example.com',
                'mat_khau' => '123456',
                'avatar' => 'https://tse2.mm.bing.net/th/id/OIP.CNf-56hALXZ1xe-84TIT6gHaHa?pid=Api&P=0&h=220',
                'ngay_sinh' => '1990-01-01',
                'gioi_tinh' => 'Nam',
                'so_dien_thoai' => '0123456789',
                'dia_chi' => 'Ha Noi',
                'ma_nguoi_dung' => '2',
                'trang_thai' => '1'
            ],
            [
                'ten_ung_vien' => 'Tran Thi B',
                'email' => 'tranthib@example.com',
                'mat_khau' => '123456',
                'avatar' => 'https://tse3.mm.bing.net/th/id/OIP.6QvanRDdlMtM6cKYpxqtPAHaG9?pid=Api&P=0&h=220',
                'ngay_sinh' => '1992-02-02',
                'gioi_tinh' => 'Nữ',
                'so_dien_thoai' => '0987654321',
                'dia_chi' => 'Ho Chi Minh',
                'ma_nguoi_dung' => '2',
                'trang_thai' => '1'
            ],
        ]);
    }
}
