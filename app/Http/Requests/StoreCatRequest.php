<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'breed' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'in:male,female'],
            'age_estimate' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:rescued,in_treatment,ready_for_adoption,adopted'],
            'rescue_location' => ['nullable', 'string', 'max:150'],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
