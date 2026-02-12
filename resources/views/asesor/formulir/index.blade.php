@extends('layouts.asesor')

@section('title', 'Formulir Asesmen')

@section('content')
<!-- ✅ BREADCRUMB -->
<div class="asesor-breadcrumb">
    <a href="{{ route('asesor.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
    <span class="separator">›</span>
    <a href="{{ route('asesor.pengajuan.show', $pengajuan->id) }}">Detail Pengajuan</a>
    <span class="separator">›</span>
    <span>Formulir Asesmen</span>
</div>

<!-- ✅ CARD HEADER -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header-brand">
        <h5><i class="bi bi-file-earmark-text"></i> Formulir Asesmen BNSP</h5>
    </div>
    <div class="card-body p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Nama Asesi:</div>
                    <div class="info-value">{{ $pengajuan->user->nama }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $pengajuan->user->email }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Skema:</div>
                    <div class="info-value"><strong>{{ $pengajuan->program->nama }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Pengajuan:</div>
                    <div class="info-value">{{ $pengajuan->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ SUCCESS MESSAGE -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- ✅ DAFTAR FORMULIR -->
<div class="card border-0 shadow-sm">
    <div class="card-header" style="background: #f4f6fc; border-bottom: 2px solid #233C7E;">
        <h6 class="mb-0" style="color: #233C7E;"><i class="bi bi-list-check"></i> Daftar Formulir Asesmen</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="width: 120px;">Kode</th>
                        <th>Nama Formulir</th>
                        <th style="width: 150px;" class="text-center">Status</th>
                        <th style="width: 200px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($formTypes as $kode => $nama)
                    @php
                        $form = $existingForms->get($kode);
                        $status = $form ? $form->status : 'belum diisi';
                    @endphp
                    <tr>
                        <td><strong>{{ str_replace('_', '.', $kode) }}</strong></td>
                        <td>{{ $nama }}</td>
                        <td class="text-center">
                            @if($status === 'selesai')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                            @elseif($status === 'draft')
                                <span class="badge bg-warning">
                                    <i class="bi bi-pencil"></i> Draft
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-dash-circle"></i> Belum Diisi
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                @if($form)
                                    <a href="{{ route('asesor.formulir.show', [$pengajuan->id, $kode]) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="{{ route('asesor.formulir.cetak', [$pengajuan->id, $kode]) }}" 
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-printer"></i> Cetak
                                    </a>
                                @else
                                    <a href="{{ route('asesor.formulir.show', [$pengajuan->id, $kode]) }}" 
                                       class="btn btn-sm btn-success">
                                        <i class="bi bi-plus-circle"></i> Isi Formulir
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ✅ TOMBOL KEMBALI -->
<div class="mt-3">
    <a href="{{ route('asesor.pengajuan.show', $pengajuan->id) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Detail Pengajuan
    </a>
</div>

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
