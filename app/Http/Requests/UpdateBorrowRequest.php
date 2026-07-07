<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBorrowRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Peminjam Wajib Diisi',
            'user_id.exists' => 'Peminjam Tidak Ditemukan',
            'book_id.required' => 'Buku Wajib Diisi',
            'book_id.exists' => 'Buku Tidak Ditemukan',
            'date_start.required' => 'Tanggal Pinjam Wajib Diisi',
            'date_end.required' => 'Tanggal Kembali Wajib Diisi',
            'date_end.after_or_equal' => 'Tanggal Kembali Tidak Boleh Sebelum Tanggal Pinjam',
        ];
    }
}
