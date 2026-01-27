<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanSkema;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
     public function show($id)
    {
        // Pastikan pengajuan ini memang milik asesor ini
        $pengajuan = PengajuanSkema::whereHas('asesors', function ($q) {
                $q->where('users.id', Auth::id());
            })
            ->with(['user', 'program', 'selfAssessments', 'buktiKompetensi'])
            ->findOrFail($id);

        return view('asesor.pengajuan.show', compact('pengajuan'));
    }
}
