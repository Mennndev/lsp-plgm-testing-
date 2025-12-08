<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramPelatihan;
use App\Models\UnitKompetensi;
use App\Models\User;
use App\Models\ProfesiTerkait;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
     public function index()
    {
        // STAT KOTAK ATAS
        $totalProgram  = ProgramPelatihan::where('is_published', 1)->count();
        $totalUnit     = UnitKompetensi::count();
        $totalProfesi  = ProfesiTerkait::count();

        // jumlah asesi = user yg pernah daftar (distinct user_id)
        $totalAsesi    = Pendaftaran::distinct('user_id')->count('user_id');

        // PROGRAM TERBARU
        $programTerbaru = ProgramPelatihan::orderByDesc('created_at')
            ->take(5)
            ->get();

        // PENDAFTARAN TERBARU (pakai relasi program() & user())
        $pendaftaranBaru = Pendaftaran::with(['program', 'user'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProgram',
            'totalUnit',
            'totalProfesi',
            'totalAsesi',
            'programTerbaru',
            'pendaftaranBaru'
        ));
    }

}

