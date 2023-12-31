<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email'     => ['required', 'email'],
            'password'  => ['required', 'string', 'min:8'],
            'remember'  => ['required', 'bool'],
        ];
    }
}
