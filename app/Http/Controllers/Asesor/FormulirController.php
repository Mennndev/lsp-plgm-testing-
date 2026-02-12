<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\FormulirAsesmen;
use App\Models\PengajuanSkema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FormulirController extends Controller
{
    /**
     * List of available assessment forms
     */
    public function index($pengajuanId)
    {
        // Ensure this pengajuan belongs to this asesor
        $pengajuan = PengajuanSkema::whereHas('asesors', function ($q) {
                $q->where('users.id', Auth::id());
            })
            ->with(['user', 'program'])
            ->findOrFail($pengajuanId);

        // Define available form types
        $formTypes = [
            'FR_IA_01' => 'Ceklis Observasi Aktivitas di Tempat Kerja',
            'FR_IA_02' => 'Tugas Praktik Demonstrasi',
            'FR_IA_05' => 'Pertanyaan Tertulis Esai',
            'FR_IA_07' => 'Pertanyaan Lisan',
            'FR_IA_11' => 'Ceklis Meninjau Portofolio',
            'FR_AK_01' => 'Persetujuan Asesmen dan Kerahasiaan',
            'FR_AK_05' => 'Laporan Hasil Asesmen',
        ];

        // Get existing forms for this pengajuan and asesor
        $existingForms = FormulirAsesmen::where('pengajuan_skema_id', $pengajuanId)
            ->where('asesor_id', Auth::id())
            ->get()
            ->keyBy('jenis_formulir');

        return view('asesor.formulir.index', compact('pengajuan', 'formTypes', 'existingForms'));
    }

    /**
     * Show form for specific form type
     */
    public function show($pengajuanId, $jenis)
    {
        // Ensure this pengajuan belongs to this asesor
        $pengajuan = PengajuanSkema::whereHas('asesors', function ($q) {
                $q->where('users.id', Auth::id());
            })
            ->with(['user', 'program'])
            ->findOrFail($pengajuanId);

        // Get existing form data if available
        $formulir = FormulirAsesmen::where('pengajuan_skema_id', $pengajuanId)
            ->where('asesor_id', Auth::id())
            ->where('jenis_formulir', $jenis)
            ->first();

        return view('asesor.formulir.show', compact('pengajuan', 'jenis', 'formulir'));
    }

    /**
     * Store form data
     */
    public function store(Request $request, $pengajuanId, $jenis)
    {
        $request->validate([
            'data' => 'required|array',
            'status' => 'required|in:draft,selesai',
        ]);

        // Ensure this pengajuan belongs to this asesor
        $pengajuan = PengajuanSkema::whereHas('asesors', function ($q) {
                $q->where('users.id', Auth::id());
            })
            ->findOrFail($pengajuanId);

        // Update or create form
        FormulirAsesmen::updateOrCreate(
            [
                'pengajuan_skema_id' => $pengajuanId,
                'asesor_id' => Auth::id(),
                'jenis_formulir' => $jenis,
            ],
            [
                'data' => $request->data,
                'status' => $request->status,
            ]
        );

        $message = $request->status === 'selesai' 
            ? 'Formulir berhasil disimpan dan diselesaikan!' 
            : 'Draft formulir berhasil disimpan!';

        return redirect()
            ->route('asesor.formulir.index', $pengajuanId)
            ->with('success', $message);
    }

    /**
     * Generate and download PDF
     */
    public function cetak($pengajuanId, $jenis)
    {
        // Ensure this pengajuan belongs to this asesor
        $pengajuan = PengajuanSkema::whereHas('asesors', function ($q) {
                $q->where('users.id', Auth::id());
            })
            ->with(['user', 'program'])
            ->findOrFail($pengajuanId);

        // Get form data
        $formulir = FormulirAsesmen::where('pengajuan_skema_id', $pengajuanId)
            ->where('asesor_id', Auth::id())
            ->where('jenis_formulir', $jenis)
            ->firstOrFail();

        // Generate PDF
        $pdf = Pdf::loadView('asesor.formulir.cetak', compact('pengajuan', 'jenis', 'formulir'));

        return $pdf->download("formulir_{$jenis}_{$pengajuan->user->nama}.pdf");
    }
}
