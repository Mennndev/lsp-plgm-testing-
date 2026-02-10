<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanAsesor;
use App\Models\KriteriaUnjukKerja;
use App\Models\PengajuanAsesorAssessment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $asesorId = auth()->id();

        $assignedPengajuan = PengajuanAsesor::with('pengajuan.user', 'pengajuan.program')
            ->where('asesor_id', $asesorId)
            ->latest()
            ->get();

        $pengajuanList = $assignedPengajuan
            ->map(function ($assignment) use ($asesorId) {
                $pengajuan = $assignment->pengajuan;

                if (! $pengajuan || ! $pengajuan->program) {
                    return null;
                }

                $totalKuk = KriteriaUnjukKerja::whereHas('elemen.unitKompetensi', function ($query) use ($pengajuan) {
                    $query->where('program_pelatihan_id', $pengajuan->program_pelatihan_id);
                })->count();

                $dinilai = PengajuanAsesorAssessment::where('pengajuan_skema_id', $pengajuan->id)
                    ->where('asesor_id', $asesorId)
                    ->count();

                $statusPenilaian = 'belum_dimulai';
                if ($totalKuk > 0 && $dinilai >= $totalKuk) {
                    $statusPenilaian = 'selesai';
                } elseif ($dinilai > 0) {
                    $statusPenilaian = 'proses';
                }

                return [
                    'assignment_id' => $assignment->id,
                    'pengajuan_id' => $pengajuan->id,
                    'nama_asesi' => $pengajuan->user->nama,
                    'nama_skema' => $pengajuan->program->nama,
                    'status_pengajuan' => $pengajuan->status,
                    'tanggal_pengajuan' => optional($pengajuan->tanggal_pengajuan)->format('d M Y'),
                    'total_kuk' => $totalKuk,
                    'dinilai' => $dinilai,
                    'persentase' => $totalKuk > 0 ? (int) round(($dinilai / $totalKuk) * 100) : 0,
                    'status_penilaian' => $statusPenilaian,
                ];
            })
            ->filter();

        $search = trim((string) $request->input('q', ''));
        $penilaianStatus = $request->input('status_penilaian', 'all');

        if ($search !== '') {
            $searchLower = mb_strtolower($search);
            $pengajuanList = $pengajuanList->filter(function ($item) use ($searchLower) {
                return str_contains(mb_strtolower($item['nama_asesi']), $searchLower)
                    || str_contains(mb_strtolower($item['nama_skema']), $searchLower)
                    || str_contains(mb_strtolower($item['status_pengajuan']), $searchLower);
            });
        }

        if ($penilaianStatus !== 'all') {
            $pengajuanList = $pengajuanList->where('status_penilaian', $penilaianStatus);
        }

        $summary = [
            'total_penugasan' => $pengajuanList->count(),
            'belum_dimulai' => $pengajuanList->where('status_penilaian', 'belum_dimulai')->count(),
            'proses' => $pengajuanList->where('status_penilaian', 'proses')->count(),
            'selesai' => $pengajuanList->where('status_penilaian', 'selesai')->count(),
        ];

        return view('asesor.dashboard', [
            'summary' => $summary,
            'pengajuanList' => $pengajuanList->values(),
            'search' => $search,
            'penilaianStatus' => $penilaianStatus,
        ]);
    }
}
