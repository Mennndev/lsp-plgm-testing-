<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    public function create()
    {
        return view('daftar');
    }

    public function store(Request $request)
    {
        // VALIDASI
        $validated = $request->validate([
            // User
            'nama'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_hp'             => ['required', 'string', 'max:20'],

            // Pendaftaran
            'jenis_kelamin'     => ['required', 'in:Laki-laki,Perempuan'],
            'tempat_lahir'      => ['required', 'string', 'max:255'],
            'tanggal_lahir'     => ['required', 'date'],
            'alamat'            => ['required', 'string'],
            'kota'              => ['required', 'string'],
            'provinsi'          => ['required', 'string'],

            'pendidikan'        => ['required', 'string'],
            'pekerjaan'         => ['required', 'string'],
            'instansi'          => ['nullable', 'string'],

            'no_ktp'            => ['required', 'digits:16'],
            'ktp'               => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'password'          => ['required', 'string', 'min:6', 'confirmed'],

            'ttd_digital'       => ['required', 'string'],
            'setuju'            => ['accepted'],
        ]);

        // 1) BUAT USER DULU
        $user = User::create([
            'nama'      => $validated['nama'],
            'email'     => $validated['email'],
            'no_hp'     => $validated['no_hp'],
            'password'  => Hash::make($validated['password']),
            'role'      => 'asesi',      // sesuai enum di tabel users
        ]);

        // 2) UPLOAD KTP → simpannya ke kolom ktp_path
        $ktpPath = null;
        if ($request->hasFile('ktp')) {
            $ktpPath = $request->file('ktp')->store('ktp', 'public');
        }

        // 3) SIMPAN TTD (base64) → file → kolom ttd_path
        $ttdPath = null;
        if (!empty($validated['ttd_digital'])) {
            [$meta, $data] = explode(',', $validated['ttd_digital']);
            $binary = base64_decode($data);

            $filename = 'ttd_' . time() . '_' . Str::random(10) . '.png';
            $ttdPath = 'ttd/' . $filename;

            Storage::disk('public')->put($ttdPath, $binary);
        }

        // 4) SIMPAN KE TABEL PENDAFTARANS
        Pendaftaran::create([
            'user_id'       => $user->id,
            'email'         => $validated['email'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir'  => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat'        => $validated['alamat'],
            'kota'          => $validated['kota'],
            'provinsi'      => $validated['provinsi'],

            'pendidikan'    => $validated['pendidikan'],
            'pekerjaan'     => $validated['pekerjaan'],
            'instansi'      => $validated['instansi'] ?? null,

            // karena field skema & jadwal tidak dipakai di form, biarkan null
            'skema'         => null,
            'jadwal'        => null,

            'no_ktp'        => $validated['no_ktp'],
            'ktp_path'      => $ktpPath,
            'ttd_path'      => $ttdPath,
            'setuju'        => 1, // karena sudah divalidasi "accepted"
        ]);

        return redirect()
            ->route('pendaftaran.create')
            ->with('success', 'Pendaftaran berhasil!');
    }
}
