<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJadwalAsesmenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'pengajuan_skema_id' => ['required', 'integer', 'exists:pengajuan_skema,id'],
            'asesor_id' => ['nullable', 'integer', 'exists:users,id'],
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:now'],
            'tanggal_selesai' => ['nullable', 'date', 'after:tanggal_mulai'],
            'mode_asesmen' => ['required', Rule::in(['offline', 'online'])],
            'lokasi' => ['nullable', 'string', 'max:255', 'required_if:mode_asesmen,offline'],
            'tautan_meeting' => ['nullable', 'url', 'max:255', 'required_if:mode_asesmen,online'],
            'status' => ['required', Rule::in(['scheduled', 'completed', 'postponed', 'cancelled'])],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai harus sama dengan atau setelah waktu saat ini.',
            'tanggal_selesai.after' => 'Tanggal selesai harus lebih dari tanggal mulai.',
            'lokasi.required_if' => 'Lokasi wajib diisi untuk asesmen offline.',
            'tautan_meeting.required_if' => 'Tautan meeting wajib diisi untuk asesmen online.',
        ];
    }
}
