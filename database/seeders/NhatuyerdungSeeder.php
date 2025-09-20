<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhatuyerdungSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('nhatuyendungs')->delete();
        DB::table('nhatuyendungs')->truncate();
        DB::table('nhatuyendungs')->insert([
            [
                'ten_cong_ty' => 'Trung tâm ngoại ngữ IELTS Fighter',
                'email' => 'contact@ieltsfighter.com',
                'mat_khau' => '123456',
                'avatar' => 'https://static.ybox.vn/2024/8/5/1722586257204-IF.png',
                'so_dien_thoai' => '0123456789',
                'dia_chi' => 'Hà nội',
                'linh_vuc' => 'LV001',
                'mo_ta' => 'Công ty chuyên đào tạo tiếng Anh IELTS',
                'website' => 'www.abc.com',
                'id_nguoi_dung' => 3,
                'trang_thai' => '1'

            ],
            [
                'ten_cong_ty' => 'Công ty FPT ',
                'email' => 'contact@abc.com',
                'mat_khau' => '123456',
                'avatar' => 'https://elitetrans.vn/images/2015/03/10/fpt-logo-color-613x375.jpeg',
                'so_dien_thoai' => '0987654321',
                'dia_chi' => 'Hồ Chí Minh',
                'linh_vuc' => 'LV002',
                'mo_ta' => 'Công ty chuyên về công nghệ thông tin',
                'website' => 'https://fpt.com/vi',
                'id_nguoi_dung' => 3,
                'trang_thai' => '1'
            ],
        ]);
    }
}
