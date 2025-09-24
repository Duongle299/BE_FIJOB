<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email'    => 'required|email|exists:ungviens,email',
            'mat_khau' => 'required|min:6|max:255',
        ];
    }
    public function messages()
    {
        return [
            'email.required'    => 'Email không được để trống.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.exists'      => 'Email không tồn tại.',
            'mat_khau.required' => 'Mật khẩu không được để trống.',
            'mat_khau.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'mat_khau.max'      => 'Mật khẩu không được quá 255 ký tự.',
        ];
    }
}

