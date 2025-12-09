<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengajuanRequest;
use App\Models\PengajuanSkema;
use App\Models\ProgramPelatihan;
use App\Models\PengajuanApl01;
use App\Models\PengajuanApl02;
use App\Models\PengajuanDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanSkemaController extends Controller
{
    public function create($programId)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('intended', route('pengajuan.create', $programId))
                ->with('error', 'Silakan login terlebih dahulu untuk mendaftar.');
        }

        // Check if program exists
        $program = ProgramPelatihan::with('units')->findOrFail($programId);

        // Check if user already has pending submission for this program
        $existingPending = PengajuanSkema::where('user_id', auth()->id())
            ->where('program_pelatihan_id', $programId)
            ->whereIn('status', ['pending', 'draft'])
            ->first();

        if ($existingPending) {
            return redirect()->route('dashboard.user')
                ->with('warning', 'Anda sudah memiliki pengajuan yang sedang diproses untuk program ini.');
        }

        return view('pengajuan.create', compact('program'));
    }

    public function store(StorePengajuanRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Create pengajuan_skema
            $pengajuan = PengajuanSkema::create([
                'user_id' => auth()->id(),
                'program_pelatihan_id' => $request->program_pelatihan_id,
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
            ]);

            // Create pengajuan_apl01
            PengajuanApl01::create([
                'pengajuan_skema_id' => $pengajuan->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'kebangsaan' => $request->kebangsaan ?? 'Indonesia',
                'alamat_rumah' => $request->alamat_rumah,
                'kode_pos' => $request->kode_pos,
                'telepon_rumah' => $request->telepon_rumah,
                'telepon_kantor' => $request->telepon_kantor,
                'email' => $request->email,
                'kualifikasi_pendidikan' => $request->kualifikasi_pendidikan,
                'nama_institusi' => $request->nama_institusi,
                'jabatan' => $request->jabatan,
                'alamat_kantor' => $request->alamat_kantor,
                'telepon_kantor_pekerjaan' => $request->telepon_kantor_pekerjaan,
                'fax' => $request->fax,
                'email_kantor' => $request->email_kantor,
                'nama_sertifikat' => $request->nama_sertifikat,
                'nomor_sertifikat' => $request->nomor_sertifikat,
                'tujuan_asesmen' => $request->tujuan_asesmen,
                'bukti_penyertaan_dasar' => $request->bukti_penyertaan_dasar,
                'bukti_administrasif' => $request->bukti_administrasif,
                'catatan' => $request->catatan,
            ]);

            // Create pengajuan_apl02 for each unit
            if ($request->has('self_assessment')) {
                foreach ($request->self_assessment as $unitId => $assessment) {
                    PengajuanApl02::create([
                        'pengajuan_skema_id' => $pengajuan->id,
                        'unit_kompetensi_id' => $unitId,
                        'self_assessment' => $assessment,
                    ]);
                }
            }

            // Handle file uploads
            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $index => $file) {
                    $jenisDokumen = $request->jenis_dokumen[$index] ?? 'lainnya';
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('pengajuan_dokumen', $fileName, 'public');

                    PengajuanDokumen::create([
                        'pengajuan_skema_id' => $pengajuan->id,
                        'jenis_dokumen' => $jenisDokumen,
                        'nama_file' => $file->getClientOriginalName(),
                        'path' => $path,
                        'ukuran' => $file->getSize(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dashboard.user')
                ->with('success', 'Pengajuan skema berhasil dikirim. Mohon menunggu konfirmasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengajuan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pengajuan = PengajuanSkema::with(['program', 'apl01', 'apl02.unitKompetensi', 'dokumen', 'approver'])
            ->findOrFail($id);

        // Check authorization (user owns it or user is admin)
        if (auth()->user()->role !== 'admin' && $pengajuan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }

        return view('pengajuan.show', compact('pengajuan'));
    }

    public function draft(Request $request)
    {
        // Save draft data to session
        $request->session()->put('pengajuan_draft', $request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Draft berhasil disimpan.'
        ]);
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanSkema::findOrFail($id);

        // Check authorization
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus pengajuan ini.');
        }

        // Only allow delete if status is 'draft'
        if ($pengajuan->status !== 'draft') {
            return back()->with('error', 'Hanya pengajuan dengan status draft yang dapat dihapus.');
        }

        // Delete related documents from storage
        foreach ($pengajuan->dokumen as $dokumen) {
            Storage::disk('public')->delete($dokumen->path);
        }

        $pengajuan->delete();

        return redirect()->route('dashboard.user')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }
}
