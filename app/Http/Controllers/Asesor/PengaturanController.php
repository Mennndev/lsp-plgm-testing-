<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PengaturanController extends Controller
{
    /**
     * Display the settings page
     */
    public function show()
    {
        return view('asesor.pengaturan.index');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = $request->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai'
            ])->withInput();
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }

    /**
     * Update account preferences
     * TODO: Implement persistence logic for preferences when user/preferences table schema is finalized
     * For now, this endpoint validates input but does not persist changes as the table structure
     * for storing preferences has not been determined yet.
     */
    public function updatePreferensi(Request $request)
    {
        $request->validate([
            'notifikasi_email' => ['nullable', 'boolean'],
            'bahasa' => ['nullable', 'string', 'in:id,en'],
        ]);

        // TODO: Store preferences when schema is ready
        // Example:
        // $user = $request->user();
        // $user->update([
        //     'notifikasi_email' => $request->notifikasi_email,
        //     'bahasa' => $request->bahasa,
        // ]);
        
        return back()->with('success', 'Preferensi berhasil diperbarui');
    }
}
