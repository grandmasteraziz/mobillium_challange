<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
   

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => "string|max:255",
            "last_name" => "string|max:255",
            "email" => "string|email|max:150|unique:users",
            "password" => "string|min:6|confirmed",
            "tckn" => "string|size:11|unique:users",
        ];
    }
}
