<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAsesorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $asesorRouteParam = $this->route('asesor');
        $asesorId = is_object($asesorRouteParam) ? $asesorRouteParam->getKey() : $asesorRouteParam;
        
        return [
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($asesorId),
            ],
            'password' => 'nullable|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/|confirmed',
            'password_confirmation' => 'required_with:password',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status_aktif' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.regex' => 'Password harus mengandung kombinasi huruf dan angka',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password_confirmation.required_with' => 'Konfirmasi password wajib diisi ketika mengubah password',
            'no_hp.required' => 'Nomor telepon wajib diisi',
        ];
    }
}
