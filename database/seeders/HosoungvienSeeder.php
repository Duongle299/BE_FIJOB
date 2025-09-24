<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HosoungvienSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hosoungviens')->delete();
        DB::table('hosoungviens')->truncate();
        DB::table('hosoungviens')->insert([
            [
                'id_ung_vien' => 1,
                'ho_ten' => 'Nguyễn Văn A',
                'hon_nhan' => 'Độc thân',
                'trinh_do_hoc_van' => 'Đại học',
                'cap_bac_mong_muon' => 'Nhân viên',
                'ky_nang' => 'PHP, Laravel, MySQL',
                'vi_tri_ung_tuyen' => 'Lập trình viên backend',
                'nganh_nghe' => 'Công nghệ thông tin',
                'kinh_nghiem' => '2 năm',
                'trang_thai' => 1,
            ],
            [
                'id_ung_vien' => 2,
                'ho_ten' => 'Trần Thị B',
                'hon_nhan' => 'Đã kết hôn',
                'trinh_do_hoc_van' => 'Cao đẳng',
                'cap_bac_mong_muon' => 'Chuyên viên',
                'ky_nang' => 'Marketing, SEO, Content',
                'vi_tri_ung_tuyen' => 'Chuyên viên Marketing',
                'nganh_nghe' => 'Marketing',
                'kinh_nghiem' => '3 năm',
                'trang_thai' => 1,
            ],
        ]);
    }
}
