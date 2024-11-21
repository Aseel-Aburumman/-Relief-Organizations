<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'contact_info' => 'required|string|max:255',
        ];
    }
}

