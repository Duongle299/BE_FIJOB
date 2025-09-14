<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XoabaivietRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ma_bai_viet'   => 'required|exists:baiviets,ma_bai_viet|max:10',
        ];
    }
    public function messages(): array
    {
        return [
            'ma_bai_viet.required'   => 'Mã bài viết là bắt buộc.',
            'ma_bai_viet.exists'     => 'Mã bài viết không tồn tại.',
            'ma_bai_viet.max'        => 'Mã bài viết không được vượt quá 10 ký tự.',
        ];
    }
}
