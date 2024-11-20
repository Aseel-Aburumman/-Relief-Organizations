<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'name_en' => 'required|string|max:255', // English name
            'name_ar' => 'required|string|max:255', // Arabic name
            'location_en' => 'required|string|max:255', // English name
            'location_ar' => 'required|string|max:255', // Arabic name
        ];
    }
}
