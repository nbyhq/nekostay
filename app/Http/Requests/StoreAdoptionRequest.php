<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdoptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cat_id' => ['required', 'exists:cats,id'],
            'adopter_name' => ['required', 'string', 'max:150'],
            'adopter_phone' => ['required', 'string', 'max:30'],
            'adopter_address' => ['nullable', 'string', 'max:500'],
            'status' => ['sometimes', 'in:pending,approved,rejected'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'cat_id.required' => 'Silakan pilih kucing yang akan diadopsi.',
            'cat_id.exists' => 'Kucing yang dipilih tidak ditemukan.',
            'adopter_name.required' => 'Nama calon adopter wajib diisi.',
            'adopter_phone.required' => 'Nomor telepon calon adopter wajib diisi.',
        ];
    }
}
