<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // proses login (ini sudah kamu punya)
        $request->authenticate();
        $request->session()->regenerate();

        // ambil user yang baru login
        $user = $request->user(); // sama saja dengan Auth::user()

        // ==== LOGIKA REDIRECT BERDASARKAN ROLE ====
        if ($user->role === 'admin') {                  // <- ganti 'role' dengan field kamu
            return redirect()->route('admin.dashboard');
        }

        // default: user biasa
        return redirect()->route('user.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
