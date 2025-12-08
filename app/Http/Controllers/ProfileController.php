<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{



    public function edit(Request $request): View
    {

        $user = $request->user();

        $pendaftaran = Pendaftaran::where('user_id', $user->id)
        ->latest()
        ->first();

        return view('ProfileUser.edit', compact('user', 'pendaftaran'));

    }

    /**
     * Update the user's profile information.
     */
  public function update(ProfileUpdateRequest $request): RedirectResponse
{
    Log::info('PROFILE UPDATE', $request->all());

    $user = Auth::user();
    $validated = $request->validated();

    DB::transaction(function () use ($user, $validated) {

        // --- UPDATE TABEL USERS ---
        $user->update([
            'nama'  => $validated['nama'],
            'no_hp' => $validated['no_hp'] ?? null,
            // TIDAK MENYENTUH EMAIL DI SINI
        ]);

        // --- UPDATE / BUAT DATA PENDAFTARAN ---
        $pendaftaran = Pendaftaran::firstOrCreate(
            ['user_id' => $user->id],
            ['email'   => $user->email]   // isi awal email dari users
        );

        $pendaftaran->update([
            'email'         => $user->email, // selalu sinkron dengan tabel users
            'tempat_lahir'  => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_ktp'        => $validated['no_ktp'],
            'alamat'        => $validated['alamat'],
            'kota'          => $validated['kota'],
            'provinsi'      => $validated['provinsi'],
            'pendidikan'    => $validated['pendidikan'],
            'pekerjaan'     => $validated['pekerjaan'],
            'instansi'      => $validated['instansi'] ?? null,
        ]);
    });

    return redirect()
        ->route('ProfileUser.edit')
        ->with('status', 'profile-updated');
}



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                ->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('password-updated', true);
    }

    public function updateSignature(Request $request): RedirectResponse
    {
        $user= $request->user();

        $validated=$request->validate([
            'ttd_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'ttd_digital' => ['nullable', 'string'],
        ]);

        $pendaftaran= Pendaftaran::where('email', $user->email)->latest()->first();

        if(!$pendaftaran){
            return back()->withErrors([
                'ttd_file' => 'Tidak ditemukan data pendaftaran yang terhubung dengan akun ini'
            ]);
        }

        if($request->hasFile('ttd_file')){
            $path = $request->file('ttd_file')->store('ttd', 'public');
            $pendaftaran->ttd_path = $path;
        }

        if (!empty($validated['ttd_digital'])){
            if (str_contains($validated['ttd_digital'], ',')){
                [$meta, $data] = explode(',', $validated['ttd_digital']);
            }else{
                $data = $validated['ttd_digital'];
            }

            $binary = base64_decode($data);
            $filename = 'ttd_'.time().'_'.Str::random(10).'.png';
            $path = 'ttd/'.$filename;

            Storage::disk('public')->put($path, $binary);
            $pendaftaran->ttd_path = $path;
        }

        if ($pendaftaran->isDirty('ttd_path')){
            $pendaftaran->save();
        }

        return back()->with('status', 'signature-updated');
    }
}
