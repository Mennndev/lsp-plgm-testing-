<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSkema;
use App\Models\PengajuanAsesorAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function show($pengajuanId)
    {
        $pengajuan = PengajuanSkema::whereHas('asesors', function ($query) {
                $query->where('users.id', Auth::id());
            })
            ->with('user', 'program.units.elemenKompetensis.kriteriaUnjukKerja')
            ->findOrFail($pengajuanId);

        return view('asesor.penilaian.show', compact('pengajuan'));
    }

    public function store(Request $request, $pengajuanId)
    {
        $request->validate([
            'nilai' => ['required', 'array'],
            'nilai.*' => ['required', 'in:kompeten,belum_kompeten'],
            'catatan' => ['nullable', 'array'],
            'catatan.*' => ['nullable', 'string'],
        ]);

        foreach ($request->input('nilai', []) as $kukId => $nilai) {
            PengajuanAsesorAssessment::updateOrCreate(
                [
                    'pengajuan_skema_id' => $pengajuanId,
                    'kriteria_unjuk_kerja_id' => $kukId,
                    'asesor_id' => Auth::id(),
                ],
                [
                    'nilai' => $nilai,
                    'catatan' => $request->input("catatan.$kukId"),
                ]
            );
        }

        return redirect()->route('asesor.dashboard')->with('success', 'Penilaian berhasil disimpan');
    }
}
