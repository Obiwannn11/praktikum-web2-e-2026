<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'writer' => 'required|string|min:1|max:100',
            'title' => 'required|string|max:100',
            'release_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Wajib Terhubung Kategori',
            'category_id.exists' => 'Kategori Tidak Ditemukan',
            'writer.max' => 'Nama Penulis Maksimal :max Karakter',
            'writer.min' => 'Nama Penulis Minimal :min Karakter',
            'title.max' => 'Judul Buku Maksimal :max Karakter',
            'release_date.required' => 'Tanggal Terbit Wajib Diisi',
            'release_date.date' => 'Format Tanggal Terbit Tidak Valid',
        ];
    }
}
