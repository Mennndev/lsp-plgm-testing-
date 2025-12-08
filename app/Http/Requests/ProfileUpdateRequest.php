<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // user yang sudah login boleh update profil
        return true;
    }

    public function rules(): array
{
    // user yang sedang login
    $user = Auth::user();

    return [

        // ----- DATA USER (tabel users) -----
        'nama'   => ['required', 'string', 'max:100'],
        'no_hp'  => ['nullable', 'string', 'max:20'],
        // EMAIL TIDAK PERLU DIUBAH DI SINI, JADI DIHAPUS DARI RULE
        // 'email' => ['required','email','max:100','unique:users,email,'.$user->id],

        // ----- DATA PENDAFTARAN (tabel pendaftarans) -----
        'tempat_lahir'   => ['required', 'string', 'max:100'],
        'tanggal_lahir'  => ['required', 'date'],
        'jenis_kelamin'  => ['required', 'string', 'max:20'],
        'no_ktp'         => ['required', 'string', 'max:100'],
        'alamat'         => ['required', 'string'],
        'kota'           => ['required', 'string', 'max:100'],
        'provinsi'       => ['required', 'string', 'max:100'],
        'pendidikan'     => ['required', 'string', 'max:50'],
        'pekerjaan'      => ['required', 'string', 'max:100'],
        'instansi'       => ['nullable', 'string', 'max:150'],
    ];
}

    public function messages(): array
    {
        return [
            'nama.required'          => 'Nama wajib diisi.',
            'no_hp.required'         => 'No. HP wajib diisi.',
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'no_ktp.required'        => 'NIK/No. KTP wajib diisi.',
            'no_ktp.digits'          => 'NIK harus 16 digit angka.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'kota.required'          => 'Kota/Kabupaten wajib diisi.',
            'provinsi.required'      => 'Provinsi wajib diisi.',
            'pendidikan.required'    => 'Pendidikan terakhir wajib diisi.',
            'pekerjaan.required'     => 'Pekerjaan wajib diisi.',
        ];
    }
}
