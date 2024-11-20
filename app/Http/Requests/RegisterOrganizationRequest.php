<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterOrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            // 'user_id' => 'required',
            'name_en' => 'required|string|max:255', // English name
            'name_ar' => 'required|string|max:255', // Arabic name
            'location_en' => 'required|string|max:255', // English name
            'location_ar' => 'required|string|max:255', // Arabic name
            'contact_info' => 'required|string|max:20',
            'description_en' => 'nullable|string|max:1000', // English description
            'description_ar' => 'nullable|string|max:1000', // Arabic description
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
