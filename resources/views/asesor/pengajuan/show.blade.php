@extends('layouts.asesor')

@section('title', 'Detail Pengajuan')

@section('content')
<!-- ✅ BREADCRUMB -->
<div class="asesor-breadcrumb">
    <a href="{{ route('asesor.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
    <span class="separator">›</span>
    <span>Detail Pengajuan</span>
</div>

<!-- ✅ CARD HEADER BRAND -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header-brand">
        <h5><i class="bi bi-file-earmark-text"></i> Detail Pengajuan Asesi</h5>
    </div>
    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Nama Asesi:</div>
                    <div class="info-value">{{ $pengajuan->user->nama }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $pengajuan->user->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Skema:</div>
                    <div class="info-value"><strong>{{ $pengajuan->program->nama }}</strong></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Tanggal Pengajuan:</div>
                    <div class="info-value">{{ $pengajuan->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="badge" style="background: #D69F3A; color: #111;">{{ ucfirst($pengajuan->status) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ SECTION SELF-ASSESSMENT -->
@if($pengajuan->selfAssessments && $pengajuan->selfAssessments->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header" style="background: #f4f6fc; border-bottom: 2px solid #233C7E;">
        <h6 class="mb-0" style="color: #233C7E;"><i class="bi bi-clipboard-check"></i> Self-Assessment Asesi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Unit Kompetensi</th>
                        <th>Elemen</th>
                        <th>KUK</th>
                        <th>Self-Assessment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan->selfAssessments as $sa)
                    <tr>
                        <td>{{ $sa->kriteriaUnjukKerja->elemenKompetensi->unitKompetensi->judul_unit ?? '-' }}</td>
                        <td>{{ $sa->kriteriaUnjukKerja->elemenKompetensi->nama_elemen ?? '-' }}</td>
                        <td>{{ $sa->kriteriaUnjukKerja->deskripsi ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $sa->nilai === 'k' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $sa->nilai === 'k' ? 'Kompeten' : 'Belum Kompeten' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- ✅ SECTION BUKTI KOMPETENSI -->
@if($pengajuan->buktiKompetensi && $pengajuan->buktiKompetensi->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header" style="background: #f4f6fc; border-bottom: 2px solid #233C7E;">
        <h6 class="mb-0" style="color: #233C7E;"><i class="bi bi-folder2-open"></i> Bukti Kompetensi</h6>
    </div>
    <div class="card-body">
        <div class="list-group">
            @foreach($pengajuan->buktiKompetensi as $bukti)
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">{{ $bukti->nama_file }}</h6>
                        <small class="text-muted">{{ $bukti->deskripsi ?? 'Tidak ada deskripsi' }}</small>
                    </div>
                    <a href="{{ asset('storage/' . $bukti->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-download"></i> Unduh
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- ✅ TOMBOL AKSI -->
<div class="d-flex gap-2">
    <a href="{{ route('asesor.pengajuan.penilaian', $pengajuan->id) }}" class="btn btn-asesor btn-primary-asesor">
        <i class="bi bi-clipboard-check"></i> Mulai Penilaian
    </a>
    <a href="{{ route('asesor.formulir.index', $pengajuan->id) }}" class="btn btn-asesor" style="background: #D69F3A; color: #fff; border: none;">
        <i class="bi bi-file-earmark-text"></i> Formulir Asesmen
    </a>
    <a href="{{ route('asesor.dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>
@endsection
