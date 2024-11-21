<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'item_name' => 'sometimes|array',
            'description' => 'sometimes|array',
            'quantity_needed' => 'required|integer|min:1', // Quantity must be a positive integer
            'urgency' => 'required|in:Low Priority,Medium Priority,High Priority', // Urgency must be one of these values
            'status' => 'required|in:Available,Partially Fulfilled,Fulfilled', // Status must be one of these values
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image with validation
            'category_id' => 'required|exists:categories,id', // Ensure category exists
        ];
    }

    public function authorize(): bool
    {
        return true; // Ensure the user is authorized to create a Need
    }
}
// Lorem ipsum dolor sit amet.
// Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia eos ab reprehenderit odio, nesciunt eveniet?
// لوريم2
// لوريم إيبسوم هو نص عربي
// لوريم إيبسوم هو نص عربي غير معنى، يُستخدم في مجالات الطباعة ومواقع الويب كنص دال على الش
