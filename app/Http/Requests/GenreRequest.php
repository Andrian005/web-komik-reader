<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nama' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:genres,slug' . ($id ? ',' . $id : ''),
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama Harus di Isi',
            'slug.required' => 'Slug Harus di Isi',
            'slug.unique' => 'Slug sudah digunakan, gunakan slug lain',
        ];
    }
}
