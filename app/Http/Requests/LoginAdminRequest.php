<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'mat_khau' => 'required|min:6',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required'    => 'Email là bắt buộc.',
            'email.email'       => 'Email không đúng định dạng.',
            'mat_khau.required' => 'Mật khẩu là bắt buộc.',
            'mat_khau.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ];
    }
}
