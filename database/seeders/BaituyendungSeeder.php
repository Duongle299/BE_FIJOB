<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaituyendungSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('baituyendungs')->delete();
        DB::table('baituyendungs')->truncate();
        DB::table('baituyendungs')->insert([
            [
                'ma_bai_tuyen_dung' => 'BTD001',
                'tieu_de' => 'Giáo viên tiếng anh IELTS',
                'hinh_anh' => 'https://media.jobsgo.vn/media/img/employer/119864-200x200.jpg?v=1749548341',
                'mo_ta_cong_viec' => 'Giảng dạy tiếng Anh cho học sinh chuẩn bị thi IELTS.',
                'yeu_cau' => 'Có chứng chỉ IELTS từ 7.0 trở lên, kinh nghiệm giảng dạy là một lợi thế.',
                'muc_luong' => '20-25 triệu VND',
                'dia_diem' => 'Hà Nội',
                'trang_thai' => 1,
                'ngay_dang' => '2024-10-01',
                'han_nop' => '2024-10-31',
                'ma_nha_tuyen_dung' => 'NTD001',
                'ma_linh_vuc' => 'LV001'
            ],
        ]);
    }
}
