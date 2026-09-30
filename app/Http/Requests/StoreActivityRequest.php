<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'min:5', 'max:100'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'activity_date' => ['required', 'date'],
            'category_id'   => ['required', 'integer', 'exists:categories,id'],
            'code'          => ['required', 'string', 'max:30', 'unique:activities,code'],
            'status'        => [
                'required',
                Rule::in(['Planned', 'Ongoing', 'Done']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak tersedia.',
            'code.unique'          => 'Kode kegiatan sudah dipakai kegiatan lain.',
        ];
    }
}