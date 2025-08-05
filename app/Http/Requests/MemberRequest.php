<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member') ? $this->route('member')->id : null;
        $userId = $this->route('member') ? $this->route('member')->user_id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => $this->isMethod('post') ? 'required|min:8' : 'nullable|min:8',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('members')->ignore($memberId),
            ],
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:L,P',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|numeric|min:0',
            'join_date' => 'nullable|date',
            'status' => 'nullable|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'nik.required' => 'NIK harus diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'birth_date.before' => 'Tanggal lahir tidak valid.',
            'monthly_income.min' => 'Penghasilan tidak boleh negatif.',
        ];
    }
}
