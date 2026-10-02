<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivityRequest extends FormRequest
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
            'code'          => [
                'required',
                'string',
                'max:30',
                Rule::unique('activities', 'code')->ignore($this->route('activity'))
            ],
            'status'        => [
                'required',
                Rule::in(['Planned', 'Ongoing', 'Done']),
            ],
            'poster'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // baris baru
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak tersedia.',
            'code.unique'          => 'Kode kegiatan sudah dipakai kegiatan lain.',
            'poster.image'         => 'Poster harus berupa gambar.',
            'poster.mimes'         => 'Poster harus berformat JPG, PNG, atau WEBP.',
            'poster.max'           => 'Ukuran poster maksimal 2 MB.',
            'poster.uploaded'      => 'Poster gagal diunggah. Ukuran maksimal 2 MB.',
        ];
    }
}