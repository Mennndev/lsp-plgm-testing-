<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\PengajuanAsesor;
use App\Models\KriteriaUnjukKerja;
use App\Models\PengajuanAsesorAssessment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $asesorId = auth()->id();

        $assignedPengajuan = PengajuanAsesor::with('pengajuan.user', 'pengajuan.program')
            ->where('asesor_id', $asesorId)
            ->latest()
            ->get();

        // Pre-load totalKuk counts grouped by program_pelatihan_id to avoid N+1
        $programIds = $assignedPengajuan->pluck('pengajuan.program_pelatihan_id')->filter()->unique();
        $kukCountsByProgram = KriteriaUnjukKerja::select('unit_kompetensis.program_pelatihan_id', DB::raw('COUNT(*) as total'))
            ->join('elemen_kompetensis', 'kriteria_unjuk_kerja.elemen_kompetensi_id', '=', 'elemen_kompetensis.id')
            ->join('unit_kompetensis', 'elemen_kompetensis.unit_kompetensi_id', '=', 'unit_kompetensis.id')
            ->whereIn('unit_kompetensis.program_pelatihan_id', $programIds)
            ->groupBy('unit_kompetensis.program_pelatihan_id')
            ->pluck('total', 'program_pelatihan_id');

        // Pre-load dinilai counts grouped by pengajuan_skema_id to avoid N+1
        $pengajuanIds = $assignedPengajuan->pluck('pengajuan_skema_id')->filter()->unique();
        $dinilaiCountsByPengajuan = PengajuanAsesorAssessment::select('pengajuan_skema_id', DB::raw('COUNT(*) as total'))
            ->where('asesor_id', $asesorId)
            ->whereIn('pengajuan_skema_id', $pengajuanIds)
            ->groupBy('pengajuan_skema_id')
            ->pluck('total', 'pengajuan_skema_id');

        $pengajuanList = $assignedPengajuan
            ->map(function ($assignment) use ($kukCountsByProgram, $dinilaiCountsByPengajuan) {
                $pengajuan = $assignment->pengajuan;

                if (! $pengajuan || ! $pengajuan->program) {
                    return null;
                }

                // Use pre-loaded data instead of querying
                $totalKuk = $kukCountsByProgram[$pengajuan->program_pelatihan_id] ?? 0;
                $dinilai = $dinilaiCountsByPengajuan[$pengajuan->id] ?? 0;

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

        // Calculate summary BEFORE applying filters
        $summary = [
            'total_penugasan' => $pengajuanList->count(),
            'belum_dimulai' => $pengajuanList->where('status_penilaian', 'belum_dimulai')->count(),
            'proses' => $pengajuanList->where('status_penilaian', 'proses')->count(),
            'selesai' => $pengajuanList->where('status_penilaian', 'selesai')->count(),
        ];

        // Apply filters AFTER summary calculation
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

        // Paginate the filtered results
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $pengajuanList->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedList = new LengthAwarePaginator(
            $currentItems,
            $pengajuanList->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('asesor.dashboard', [
            'summary' => $summary,
            'pengajuanList' => $paginatedList,
            'search' => $search,
            'penilaianStatus' => $penilaianStatus,
        ]);
    }
}
