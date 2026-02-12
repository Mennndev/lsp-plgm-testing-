@extends('layouts.asesor')

@section('title', 'Isi Formulir Asesmen')

@section('content')
<!-- ✅ BREADCRUMB -->
<div class="asesor-breadcrumb">
    <a href="{{ route('asesor.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
    <span class="separator">›</span>
    <a href="{{ route('asesor.pengajuan.show', $pengajuan->id) }}">Detail Pengajuan</a>
    <span class="separator">›</span>
    <a href="{{ route('asesor.formulir.index', $pengajuan->id) }}">Formulir Asesmen</a>
    <span class="separator">›</span>
    <span>{{ str_replace('_', '.', $jenis) }}</span>
</div>

<!-- ✅ CARD HEADER -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header-brand">
        <h5><i class="bi bi-file-earmark-text"></i> Formulir {{ str_replace('_', '.', $jenis) }}</h5>
    </div>
    <div class="card-body p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Nama Asesi:</div>
                    <div class="info-value">{{ $pengajuan->user->nama }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Skema:</div>
                    <div class="info-value"><strong>{{ $pengajuan->program->nama }}</strong></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Asesor:</div>
                    <div class="info-value">{{ Auth::user()->nama }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal:</div>
                    <div class="info-value">{{ now()->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ FORM ISIAN -->
<form action="{{ route('asesor.formulir.store', [$pengajuan->id, $jenis]) }}" method="POST">
    @csrf
    
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header" style="background: #f4f6fc; border-bottom: 2px solid #233C7E;">
            <h6 class="mb-0" style="color: #233C7E;"><i class="bi bi-pencil-square"></i> Isian Formulir</h6>
        </div>
        <div class="card-body">
            @php
                $formData = $formulir ? $formulir->data : [];
            @endphp

            @if($jenis === 'FR_IA_01')
                <!-- FR.IA.01: Ceklis Observasi Aktivitas di Tempat Kerja -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Lokasi Observasi</label>
                    <input type="text" class="form-control" name="data[lokasi]" 
                           value="{{ $formData['lokasi'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Observasi</label>
                    <input type="date" class="form-control" name="data[tanggal]" 
                           value="{{ $formData['tanggal'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Aktivitas yang Diobservasi</label>
                    <textarea class="form-control" name="data[aktivitas]" rows="4" required>{{ $formData['aktivitas'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Hasil Observasi</label>
                    <textarea class="form-control" name="data[hasil]" rows="6" required>{{ $formData['hasil'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan</label>
                    <textarea class="form-control" name="data[catatan]" rows="4">{{ $formData['catatan'] ?? '' }}</textarea>
                </div>

            @elseif($jenis === 'FR_IA_02')
                <!-- FR.IA.02: Tugas Praktik Demonstrasi -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tugas yang Diberikan</label>
                    <textarea class="form-control" name="data[tugas]" rows="4" required>{{ $formData['tugas'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Pelaksanaan</label>
                    <input type="date" class="form-control" name="data[tanggal]" 
                           value="{{ $formData['tanggal'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Hasil Demonstrasi</label>
                    <textarea class="form-control" name="data[hasil]" rows="6" required>{{ $formData['hasil'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Penilaian</label>
                    <select class="form-select" name="data[penilaian]" required>
                        <option value="">-- Pilih Penilaian --</option>
                        <option value="kompeten" {{ ($formData['penilaian'] ?? '') === 'kompeten' ? 'selected' : '' }}>Kompeten</option>
                        <option value="belum_kompeten" {{ ($formData['penilaian'] ?? '') === 'belum_kompeten' ? 'selected' : '' }}>Belum Kompeten</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan</label>
                    <textarea class="form-control" name="data[catatan]" rows="4">{{ $formData['catatan'] ?? '' }}</textarea>
                </div>

            @elseif($jenis === 'FR_IA_05')
                <!-- FR.IA.05: Pertanyaan Tertulis Esai -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Pertanyaan 1</label>
                    <textarea class="form-control" name="data[pertanyaan_1]" rows="3" required>{{ $formData['pertanyaan_1'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Jawaban Asesi 1</label>
                    <textarea class="form-control" name="data[jawaban_1]" rows="4" required>{{ $formData['jawaban_1'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Pertanyaan 2</label>
                    <textarea class="form-control" name="data[pertanyaan_2]" rows="3">{{ $formData['pertanyaan_2'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Jawaban Asesi 2</label>
                    <textarea class="form-control" name="data[jawaban_2]" rows="4">{{ $formData['jawaban_2'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Evaluasi</label>
                    <textarea class="form-control" name="data[evaluasi]" rows="4" required>{{ $formData['evaluasi'] ?? '' }}</textarea>
                </div>

            @elseif($jenis === 'FR_IA_07')
                <!-- FR.IA.07: Pertanyaan Lisan -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Wawancara</label>
                    <input type="date" class="form-control" name="data[tanggal]" 
                           value="{{ $formData['tanggal'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Pertanyaan 1</label>
                    <textarea class="form-control" name="data[pertanyaan_1]" rows="3" required>{{ $formData['pertanyaan_1'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Jawaban Asesi 1</label>
                    <textarea class="form-control" name="data[jawaban_1]" rows="4" required>{{ $formData['jawaban_1'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Pertanyaan 2</label>
                    <textarea class="form-control" name="data[pertanyaan_2]" rows="3">{{ $formData['pertanyaan_2'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Jawaban Asesi 2</label>
                    <textarea class="form-control" name="data[jawaban_2]" rows="4">{{ $formData['jawaban_2'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Kesimpulan</label>
                    <textarea class="form-control" name="data[kesimpulan]" rows="4" required>{{ $formData['kesimpulan'] ?? '' }}</textarea>
                </div>

            @elseif($jenis === 'FR_IA_11')
                <!-- FR.IA.11: Ceklis Meninjau Portofolio -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Dokumen Portofolio</label>
                    <textarea class="form-control" name="data[dokumen]" rows="4" required>{{ $formData['dokumen'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Relevansi dengan Kompetensi</label>
                    <textarea class="form-control" name="data[relevansi]" rows="4" required>{{ $formData['relevansi'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Penilaian Kelengkapan</label>
                    <select class="form-select" name="data[kelengkapan]" required>
                        <option value="">-- Pilih Penilaian --</option>
                        <option value="lengkap" {{ ($formData['kelengkapan'] ?? '') === 'lengkap' ? 'selected' : '' }}>Lengkap</option>
                        <option value="tidak_lengkap" {{ ($formData['kelengkapan'] ?? '') === 'tidak_lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan</label>
                    <textarea class="form-control" name="data[catatan]" rows="4">{{ $formData['catatan'] ?? '' }}</textarea>
                </div>

            @elseif($jenis === 'FR_AK_01')
                <!-- FR.AK.01: Persetujuan Asesmen dan Kerahasiaan -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Persetujuan</label>
                    <input type="date" class="form-control" name="data[tanggal]" 
                           value="{{ $formData['tanggal'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Metode Asesmen yang Disetujui</label>
                    <textarea class="form-control" name="data[metode]" rows="4" required>{{ $formData['metode'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Jadwal Asesmen</label>
                    <textarea class="form-control" name="data[jadwal]" rows="4" required>{{ $formData['jadwal'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="data[persetujuan_asesi]" 
                               value="1" {{ ($formData['persetujuan_asesi'] ?? '') ? 'checked' : '' }} required>
                        <label class="form-check-label">
                            Asesi telah menyetujui proses asesmen dan menjaga kerahasiaan
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan</label>
                    <textarea class="form-control" name="data[catatan]" rows="4">{{ $formData['catatan'] ?? '' }}</textarea>
                </div>

            @elseif($jenis === 'FR_AK_05')
                <!-- FR.AK.05: Laporan Hasil Asesmen -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Asesmen</label>
                    <input type="date" class="form-control" name="data[tanggal]" 
                           value="{{ $formData['tanggal'] ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Metode Asesmen yang Digunakan</label>
                    <textarea class="form-control" name="data[metode]" rows="4" required>{{ $formData['metode'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ringkasan Hasil Asesmen</label>
                    <textarea class="form-control" name="data[ringkasan]" rows="6" required>{{ $formData['ringkasan'] ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Rekomendasi</label>
                    <select class="form-select" name="data[rekomendasi]" required>
                        <option value="">-- Pilih Rekomendasi --</option>
                        <option value="kompeten" {{ ($formData['rekomendasi'] ?? '') === 'kompeten' ? 'selected' : '' }}>Kompeten</option>
                        <option value="belum_kompeten" {{ ($formData['rekomendasi'] ?? '') === 'belum_kompeten' ? 'selected' : '' }}>Belum Kompeten</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan dan Saran</label>
                    <textarea class="form-control" name="data[catatan]" rows="4">{{ $formData['catatan'] ?? '' }}</textarea>
                </div>
            @endif
        </div>
    </div>

    <!-- ✅ TOMBOL AKSI -->
    <div class="d-flex gap-2 mb-4">
        <button type="submit" name="status" value="draft" class="btn btn-warning">
            <i class="bi bi-save"></i> Simpan Draft
        </button>
        <button type="submit" name="status" value="selesai" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Simpan & Selesai
        </button>
        <a href="{{ route('asesor.formulir.index', $pengajuan->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</form>

@endsection

@push('styles')
<style>
.info-row {
    display: flex;
    margin-bottom: 10px;
}
.info-label {
    font-weight: 500;
    min-width: 150px;
    color: #666;
}
.info-value {
    color: #333;
}
.card-header-brand {
    background: linear-gradient(135deg, #233C7E 0%, #1a2d5f 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 8px 8px 0 0;
}
.card-header-brand h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}
</style>
@endpush
