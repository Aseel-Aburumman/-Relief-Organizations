<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterOrganizationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            // 'user_id' => 'required',
            'name' => 'required|string|max:255',
            'address' => 'required',
            'contact_info' => 'required|string|max:20',
            'description' => 'nullable|string|max:1000',
            'certificate_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Allow images or PDFs up to 2MB

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
