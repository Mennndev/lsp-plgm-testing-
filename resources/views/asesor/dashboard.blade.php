@extends('layouts.asesor')

@section('content')
<h4 class="mb-4">Dashboard Asesor</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Total Penugasan</div>
                <div class="fs-3 fw-semibold">{{ $summary['total_penugasan'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Belum Dinilai</div>
                <div class="fs-3 fw-semibold text-secondary">{{ $summary['belum_dimulai'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Sedang Dinilai</div>
                <div class="fs-3 fw-semibold text-warning">{{ $summary['proses'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Selesai</div>
                <div class="fs-3 fw-semibold text-success">{{ $summary['selesai'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('asesor.dashboard') }}" class="row g-2 align-items-end mb-3">
            <div class="col-md-6">
                <label class="form-label">Cari Asesi / Skema / Status</label>
                <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Contoh: Lukman / Operator / approved">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Penilaian</label>
                <select name="status_penilaian" class="form-select">
                    <option value="all" {{ $penilaianStatus === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="belum_dimulai" {{ $penilaianStatus === 'belum_dimulai' ? 'selected' : '' }}>Belum Dinilai</option>
                    <option value="proses" {{ $penilaianStatus === 'proses' ? 'selected' : '' }}>Sedang Dinilai</option>
                    <option value="selesai" {{ $penilaianStatus === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary" type="submit">Terapkan</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Asesi</th>
                        <th>Skema</th>
                        <th>Status Pengajuan</th>
                        <th>Progress Penilaian</th>
                        <th>Tanggal Pengajuan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanList as $row)
                        @php
                            $statusClass = [
                                'belum_dimulai' => 'bg-secondary',
                                'proses' => 'bg-warning text-dark',
                                'selesai' => 'bg-success',
                            ][$row['status_penilaian']] ?? 'bg-secondary';

                            $statusText = [
                                'belum_dimulai' => 'Belum Dinilai',
                                'proses' => 'Sedang Dinilai',
                                'selesai' => 'Selesai',
                            ][$row['status_penilaian']] ?? 'Unknown';
                        @endphp
                        <tr>
                            <td>{{ $row['nama_asesi'] }}</td>
                            <td>{{ $row['nama_skema'] }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ ucfirst($row['status_pengajuan']) }}</span>
                            </td>
                            <td style="min-width: 220px;">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>{{ $row['dinilai'] }} / {{ $row['total_kuk'] }} KUK</span>
                                    <span>{{ $row['persentase'] }}%</span>
                                </div>
                                <div class="progress" role="progressbar" aria-label="progress penilaian" aria-valuenow="{{ $row['persentase'] }}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: {{ $row['persentase'] }}%"></div>
                                </div>
                                <span class="badge mt-2 {{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                            <td>{{ $row['tanggal_pengajuan'] ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('asesor.pengajuan.show', $row['pengajuan_id']) }}" class="btn btn-outline-primary btn-sm">
                                    Lihat Detail
                                </a>
                                @if($row['status_penilaian'] === 'selesai')
                                    <a href="{{ route('asesor.pengajuan.penilaian', $row['pengajuan_id']) }}" class="btn btn-success btn-sm">
                                        Lihat Hasil
                                    </a>
                                @elseif($row['status_penilaian'] === 'proses')
                                    <a href="{{ route('asesor.pengajuan.penilaian', $row['pengajuan_id']) }}" class="btn btn-primary btn-sm">
                                        Lanjutkan Penilaian
                                    </a>
                                @else
                                    <a href="{{ route('asesor.pengajuan.penilaian', $row['pengajuan_id']) }}" class="btn btn-primary btn-sm">
                                        Mulai Penilaian
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada data penugasan untuk filter saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuanList->hasPages())
            <div class="mt-3">
                {{ $pengajuanList->appends(['q' => $search, 'status_penilaian' => $penilaianStatus])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
