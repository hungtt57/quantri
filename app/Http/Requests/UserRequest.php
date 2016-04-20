<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $segments = $this->segments();
        $id = intval(end($segments));

        switch($this->method())
        {
        case 'GET':
        case 'DELETE':
        {
            return [];
        }
        case 'POST':
        {
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                'role' => 'required'
            ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email, ' . $id,
                'password' => 'confirmed',
            ];
        }
        default:break;
        }
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Vui lòng điền họ.',
            'last_name.required' => 'Vui lòng điền đệm và tên.',
            'email.unique' => 'Email này đã được sử dụng.',
            'email.email' => 'Email này không đúng định dạng.',
            'email.required' => 'Vui lòng điền email người dùng.',
            'password.required' => 'Vui lòng điền mật khẩu người dùng.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'role.required' => 'Vui lòng chọn role cho người dùng.'
        ];
    }
}
