<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TitleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:titles,slug' . ($id ? ',' . $id : ''),
            'type' => 'required|in:novel,manhwa,manhua,manga',
            'status' => 'required|in:ongoing,completed,hiatus',
            'synopsis' => 'required|string',
            'cover_image' => ($id ? 'nullable' : 'required') . '|image|mimes:jpeg,jpg,png|max:2048',
            'released_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'country' => 'required|string|max:100',
            'genre_id' => 'required|array',
            'genre_id.*' => 'integer|exists:genres,id',
            'author_id' => 'required|array',
            'author_id.*' => 'integer|exists:authors,id',
            'artist_id' => 'required|array',
            'artist_id.*' => 'integer|exists:artists,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',

            'slug.required' => 'Slug wajib diisi.',
            'slug.string' => 'Slug harus berupa teks.',
            'slug.max' => 'Slug maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan, gunakan slug lain.',

            'type.required' => 'Jenis/tipe wajib dipilih.',
            'type.in' => 'Tipe yang dipilih tidak valid.',

            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',

            'synopsis.required' => 'Sinopsis tidak boleh kosong.',
            'synopsis.string' => 'Sinopsis harus berupa teks.',

            'cover_image.required' => 'Gambar cover wajib diunggah.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'cover_image.max' => 'Ukuran gambar maksimal 2MB.',

            'released_year.required' => 'Tahun rilis wajib diisi.',
            'released_year.digits' => 'Tahun rilis harus 4 digit.',
            'released_year.integer' => 'Tahun rilis harus berupa angka.',
            'released_year.min' => 'Tahun rilis minimal 1900.',
            'released_year.max' => 'Tahun rilis tidak boleh lebih dari tahun sekarang.',

            'country.required' => 'Negara asal wajib diisi.',
            'country.string' => 'Negara asal harus berupa teks.',
            'country.max' => 'Negara asal maksimal 100 karakter.',

            'genre_id.required' => 'Setidaknya satu genre harus dipilih.',
            'genre_id.array' => 'Format genre tidak valid.',
            'genre_id.*.integer' => 'ID genre harus berupa angka.',
            'genre_id.*.exists' => 'Genre yang dipilih tidak ditemukan.',

            'author_id.required' => 'Setidaknya satu author harus dipilih.',
            'author_id.array' => 'Format author tidak valid.',
            'author_id.*.integer' => 'ID author harus berupa angka.',
            'author_id.*.exists' => 'Author yang dipilih tidak ditemukan.',

            'artist_id.required' => 'Setidaknya satu Artist harus dipilih.',
            'artist_id.array' => 'Format Artist tidak valid.',
            'artist_id.*.integer' => 'ID Artist harus berupa angka.',
            'artist_id.*.exists' => 'Artist yang dipilih tidak ditemukan.',
        ];
    }
}
