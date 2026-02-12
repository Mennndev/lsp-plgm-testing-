@extends('layouts.admin')

@section('title', 'Jadwal Asesmen')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Manajemen Jadwal Asesmen</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama/email asesi">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach(['scheduled' => 'Terjadwal', 'completed' => 'Selesai', 'postponed' => 'Ditunda', 'cancelled' => 'Dibatalkan'] as $key => $label)
                            <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.jadwal-asesmen.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Asesi</th>
                        <th>Skema</th>
                        <th>Waktu</th>
                        <th>Mode</th>
                        <th>Asesor</th>
                        <th>Status</th>
                        <th>Reschedule</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalList as $jadwal)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $jadwal->pengajuan->user->nama ?? '-' }}</div>
                                <small class="text-muted">{{ $jadwal->pengajuan->user->email ?? '-' }}</small>
                            </td>
                            <td>{{ $jadwal->pengajuan->program->nama ?? '-' }}</td>
                            <td>
                                {{ $jadwal->tanggal_mulai?->format('d/m/Y H:i') }}
                                @if($jadwal->tanggal_selesai)
                                    <br><small class="text-muted">s.d. {{ $jadwal->tanggal_selesai->format('d/m/Y H:i') }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $jadwal->mode_asesmen === 'online' ? 'info' : 'secondary' }}">
                                    {{ strtoupper($jadwal->mode_asesmen) }}
                                </span>
                            </td>
                            <td>{{ $jadwal->asesor->nama ?? '-' }}</td>
                            <td><span class="badge bg-{{ $jadwal->status_badge }}">{{ $jadwal->status_label }}</span></td>
                            <td>{{ $jadwal->reschedule_count }}</td>
                            <td>
                                <a href="{{ route('admin.jadwal-asesmen.form', $jadwal->pengajuan_skema_id) }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada jadwal asesmen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $jadwalList->links() }}
        </div>
    </div>
</div>
@endsection
