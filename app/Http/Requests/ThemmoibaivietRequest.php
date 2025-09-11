<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemmoibaivietRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ma_bai_viet'   => 'required|unique:baiviets,ma_bai_viet|max:10',
            'ma_danh_muc'   => 'required|exists:danhmucs,ma_danh_muc',
            'tieu_de'       => 'required|unique:baiviets,tieu_de|max:255',
            'noi_dung'      => 'required',
            'hinh_anh'      => 'required|url',
            'ngay_dang'     => 'required|date',
        ];
    }
    public function messages(): array
    {
        return [
            'ma_bai_viet.required'   => 'Mã bài viết là bắt buộc.',
            'ma_bai_viet.unique'     => 'Mã bài viết đã tồn tại.',
            'ma_bai_viet.max'        => 'Mã bài viết không được vượt quá 10 ký tự.',
            'ma_danh_muc.required'   => 'Mã danh mục là bắt buộc.',
            'ma_danh_muc.exists'     => 'Mã danh mục không hợp lệ.',
            'tieu_de.required'       => 'Tiêu đề là bắt buộc.',
            'tieu_de.unique'         => 'Tiêu đề đã tồn tại.',
            'tieu_de.max'            => 'Tiêu đề không được vượt quá 255 ký tự.',
            'noi_dung.required'      => 'Nội dung là bắt buộc.',
            'hinh_anh.required'      => 'Hình ảnh là bắt buộc.',
            'hinh_anh.url'           => 'Hình ảnh phải là một URL hợp lệ.',
            'ngay_dang.required'     => 'Ngày đăng là bắt buộc.',
            'ngay_dang.date'         => 'Ngày đăng phải là một ngày hợp lệ.',
        ];
    }
}
