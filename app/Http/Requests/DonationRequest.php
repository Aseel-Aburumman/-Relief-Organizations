<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Need;

class DonationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $need = Need::find($this->need_id);

        return [
            'quantity' => [
                'required',
                'numeric',
                'min:1',
                'max:' . ($need ? ($need->quantity_needed - $need->donated_quantity) : 0),
            ],
            'need_id' => 'required|exists:needs,id',

        ];
    }
}

