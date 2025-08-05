<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:10000',
            'transaction_date' => 'nullable|date',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Anggota harus dipilih.',
            'type.required' => 'Jenis transaksi harus dipilih.',
            'amount.required' => 'Jumlah harus diisi.',
            'amount.min' => 'Jumlah minimal Rp 10.000.',
        ];
    }
}
