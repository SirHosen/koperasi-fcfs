<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => auth()->user()->isAdmin() ? 'required|exists:members,id' : 'nullable',
            'amount' => 'required|numeric|min:500000|max:50000000',
            'duration_months' => 'required|integer|min:3|max:60',
            'purpose' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Jumlah pinjaman harus diisi.',
            'amount.min' => 'Jumlah pinjaman minimal Rp 500.000.',
            'amount.max' => 'Jumlah pinjaman maksimal Rp 50.000.000.',
            'duration_months.required' => 'Jangka waktu harus diisi.',
            'duration_months.min' => 'Jangka waktu minimal 3 bulan.',
            'duration_months.max' => 'Jangka waktu maksimal 60 bulan.',
            'purpose.required' => 'Tujuan pinjaman harus diisi.',
        ];
    }
}
