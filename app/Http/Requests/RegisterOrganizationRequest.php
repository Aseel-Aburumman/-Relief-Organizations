<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterOrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:8|confirmed',
            // 'user_id' => 'required',
            'name' => 'required|string|max:255', // English name
            'address' => 'required', // English name
            'contact_info' => 'required|string|max:20',
            'description' => 'nullable|string|max:1000', // English description
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
