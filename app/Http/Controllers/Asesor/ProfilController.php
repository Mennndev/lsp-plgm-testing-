<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $asesorProfile = $user->asesorProfile;

        // Prepare bidang keahlian data for the view
        $bidangKeahlian = old('bidang_keahlian', $asesorProfile?->bidang_keahlian ?? []);
        if (empty($bidangKeahlian)) {
            $bidangKeahlian = [''];
        }

        return view('asesor.profil.show', compact('user', 'asesorProfile', 'bidangKeahlian'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'bidang_keahlian' => 'nullable|array',
            'bidang_keahlian.*' => 'string|min:1|regex:/\S/',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Filter out empty bidang keahlian entries
        if (isset($validated['bidang_keahlian'])) {
            $validated['bidang_keahlian'] = array_values(array_filter($validated['bidang_keahlian'], function($item) {
                return !empty(trim($item));
            }));
        }

        // Update user data
        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        $user->no_hp = $validated['no_hp'] ?? null;
        $user->alamat = $validated['alamat'] ?? null;
        $user->save();

        // Get or create asesor profile
        $asesorProfile = $user->asesorProfile;
        if (!$asesorProfile) {
            $asesorProfile = $user->asesorProfile()->create([]);
        }

        // Update asesor profile data
        $asesorProfile->alamat = $validated['alamat'] ?? null;
        $asesorProfile->bidang_keahlian = $validated['bidang_keahlian'] ?? null;

        // Handle photo upload
        if ($request->hasFile('foto_profile')) {
            // Delete old photo if exists
            if ($asesorProfile->foto_profile && Storage::disk('public')->exists($asesorProfile->foto_profile)) {
                Storage::disk('public')->delete($asesorProfile->foto_profile);
            }

            // Store new photo
            $path = $request->file('foto_profile')->store('asesor/profiles', 'public');
            $asesorProfile->foto_profile = $path;
        }

        $asesorProfile->save();

        return redirect()->route('asesor.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
