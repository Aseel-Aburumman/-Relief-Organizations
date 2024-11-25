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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:8|confirmed',
            'address' => 'required|in:' . implode(',', $this->getCountryList()),
        ];
    }

    private function getCountryList()
    {
        $countries = countries();

        // Fetch only the 'name' value for each country
        $countryNames = array_map(function ($country) {
            return $country['name'];
        }, $countries);

        // dd($countryNames); // Debug the country names

        return $countryNames;
    }
}
