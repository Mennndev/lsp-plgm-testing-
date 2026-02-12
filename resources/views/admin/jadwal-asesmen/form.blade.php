@extends('layouts.admin')

@section('title', 'Kelola Jadwal Asesmen')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Kelola Jadwal Asesmen</h1>
        <a href="{{ route('admin.jadwal-asesmen.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"><strong>Asesi:</strong> {{ $pengajuan->user->nama }}</div>
                <div class="col-md-4"><strong>Email:</strong> {{ $pengajuan->user->email }}</div>
                <div class="col-md-4"><strong>Skema:</strong> {{ $pengajuan->program->nama }}</div>
            </div>
            <div class="mt-2">
                <span class="badge bg-{{ $pengajuan->status_badge_color }}">{{ $pengajuan->status_label }}</span>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.jadwal-asesmen.upsert') }}" class="row g-3">
                @csrf
                <input type="hidden" name="pengajuan_skema_id" value="{{ $pengajuan->id }}">

                <div class="col-md-6">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="datetime-local" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        value="{{ old('tanggal_mulai', optional($pengajuan->jadwalAsesmen?->tanggal_mulai)->format('Y-m-d\TH:i')) }}" required>
                    @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="datetime-local" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                        value="{{ old('tanggal_selesai', optional($pengajuan->jadwalAsesmen?->tanggal_selesai)->format('Y-m-d\TH:i')) }}">
                    @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Mode</label>
                    @php($mode = old('mode_asesmen', $pengajuan->jadwalAsesmen->mode_asesmen ?? 'offline'))
                    <select name="mode_asesmen" class="form-select" required>
                        <option value="offline" @selected($mode === 'offline')>Offline</option>
                        <option value="online" @selected($mode === 'online')>Online</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Asesor</label>
                    <select name="asesor_id" class="form-select">
                        <option value="">-- Pilih Asesor --</option>
                        @foreach($listAsesor as $asesor)
                            <option value="{{ $asesor->id }}"
                                @selected((string) old('asesor_id', $pengajuan->jadwalAsesmen->asesor_id ?? '') === (string) $asesor->id)>
                                {{ $asesor->nama ?? $asesor->name }} - {{ $asesor->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status Jadwal</label>
                    @php($status = old('status', $pengajuan->jadwalAsesmen->status ?? 'scheduled'))
                    <select name="status" class="form-select" required>
                        <option value="scheduled" @selected($status === 'scheduled')>Terjadwal</option>
                        <option value="completed" @selected($status === 'completed')>Selesai</option>
                        <option value="postponed" @selected($status === 'postponed')>Ditunda</option>
                        <option value="cancelled" @selected($status === 'cancelled')>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lokasi (offline)</label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                        value="{{ old('lokasi', $pengajuan->jadwalAsesmen->lokasi ?? '') }}" maxlength="255">
                    @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tautan Meeting (online)</label>
                    <input type="url" name="tautan_meeting" class="form-control @error('tautan_meeting') is-invalid @enderror"
                        value="{{ old('tautan_meeting', $pengajuan->jadwalAsesmen->tautan_meeting ?? '') }}" maxlength="255">
                    @error('tautan_meeting') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $pengajuan->jadwalAsesmen->catatan ?? '') }}</textarea>
                    @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                @if($pengajuan->jadwalAsesmen)
                    <div class="col-12 text-muted small">
                        Total reschedule: {{ $pengajuan->jadwalAsesmen->reschedule_count }}
                        @if($pengajuan->jadwalAsesmen->last_rescheduled_at)
                            (terakhir {{ $pengajuan->jadwalAsesmen->last_rescheduled_at->format('d/m/Y H:i') }})
                        @endif
                    </div>
                @endif

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    <a href="{{ route('admin.pengajuan.show', $pengajuan->id) }}" class="btn btn-outline-secondary">Kembali ke Detail Pengajuan</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
