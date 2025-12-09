<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Program
            'program_pelatihan_id' => 'required|exists:program_pelatihans,id',
            
            // APL-01 Data Pribadi
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kebangsaan' => 'nullable|string|max:100',
            'alamat_rumah' => 'required|string',
            'kode_pos' => 'nullable|string|max:10',
            'telepon_rumah' => 'nullable|string|max:20',
            'telepon_kantor' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            
            // APL-01 Pendidikan & Pekerjaan
            'kualifikasi_pendidikan' => 'nullable|string|max:100',
            'nama_institusi' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'alamat_kantor' => 'nullable|string',
            'telepon_kantor_pekerjaan' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'email_kantor' => 'nullable|email|max:255',
            
            // APL-01 Sertifikat
            'nama_sertifikat' => 'nullable|string|max:255',
            'nomor_sertifikat' => 'nullable|string|max:255',
            
            // APL-01 Tujuan & Bukti
            'tujuan_asesmen' => 'nullable|array',
            'bukti_penyertaan_dasar' => 'nullable|string',
            'bukti_administrasif' => 'nullable|string',
            'catatan' => 'nullable|string',
            
            // APL-02 Self Assessment
            'self_assessment' => 'required|array',
            'self_assessment.*' => 'required|array',
            
            // File uploads
            'dokumen' => 'nullable|array',
            'dokumen.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'jenis_dokumen' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'program_pelatihan_id.required' => 'Program pelatihan harus dipilih.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'email.email' => 'Format email tidak valid.',
            'self_assessment.required' => 'Self assessment wajib diisi.',
            'dokumen.*.max' => 'Ukuran file maksimal 2MB.',
            'dokumen.*.mimes' => 'File harus berformat: pdf, jpg, jpeg, png, doc, docx.',
        ];
    }
}
