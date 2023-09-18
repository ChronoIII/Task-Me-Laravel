<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:t_users,email'],
            'password'  => ['required', 'confirmed', 'min:8'],
        ];
    }
}
