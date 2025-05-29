<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            'name' => 'required',
            'slug' => 'required|unique:authors,slug' . ($id ? ',' . $id : ''),
            'bio' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Author harus di isi',
            'slug.required' => 'Slug harus di isi',
            'slug.unique' => 'Slug sudah digunakan, gunakan slug lain',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
