@extends('layouts.admin')

@section('title', 'Live Chat Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2><i class="bi bi-chat-dots"></i> Live Chat Admin</h2>
            <p class="text-muted">Kelola pertanyaan dari user melalui live chat</p>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary">
                <div class="card-body">
                    <h3 id="waitingStats">{{ isset($stats) ? $stats['waiting'] : 0 }}</h3>
                    <p class="text-muted mb-0">Menunggu Respon</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success">
                <div class="card-body">
                    <h3 id="openStats">{{ isset($stats) ? $stats['open'] : 0 }}</h3>
                    <p class="text-muted mb-0">Sedang Diproses</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-danger">
                <div class="card-body">
                    <h3 id="closedStats">{{ isset($stats) ? $stats['closed'] : 0 }}</h3>
                    <p class="text-muted mb-0">Ditutup</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info">
                <div class="card-body">
                    <h3 id="totalStats">{{ isset($stats) ? $stats['total'] : 0 }}</h3>
                    <p class="text-muted mb-0">Total Chat</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Filter Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="waiting" {{ $status === 'waiting' ? 'selected' : '' }}>Menunggu Respon</option>
                        <option value="open" {{ $status === 'open' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="closed" {{ $status === 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Chat Table --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pengguna</th>
                        <th>Subjek</th>
                        <th>Status</th>
                        <th>Admin</th>
                        <th>Pesan Terakhir</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chats as $chat)
                    <tr>
                        <td>
                            <strong>{{ $chat->user->nama }}</strong><br>
                            <small class="text-muted">{{ $chat->user->email }}</small>
                        </td>
                        <td>{{ $chat->subject ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $chat->status === 'closed' ? 'danger' : ($chat->status === 'open' ? 'success' : 'warning') }}">
                                {{ ucfirst($chat->status) }}
                            </span>
                        </td>
                        <td>
                            @if($chat->admin)
                                <span class="badge bg-info">{{ $chat->admin->nama }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-truncate d-block" style="max-width: 200px;">
                                {{ $chat->last_message ?? '-' }}
                            </small>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $chat->last_message_at ? $chat->last_message_at->diffForHumans() : $chat->created_at->diffForHumans() }}
                            </small>
                        </td>
                        <td>
                            <a href="{{ route('admin.chat.show', $chat->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-chat-left"></i> Buka
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Tidak ada chat untuk ditampilkan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($chats->hasPages())
        <div class="card-footer">
            {{ $chats->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Auto-refresh statistics setiap 10 detik
setInterval(function() {
    fetch('{{ route("admin.chat.get-stats") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('waitingStats').textContent = data.waiting;
            document.getElementById('openStats').textContent = data.open;
            document.getElementById('closedStats').textContent = data.closed;
            document.getElementById('totalStats').textContent = data.total;
        });
}, 10000);

// Auto-refresh page untuk update daftar chat setiap 5 detik
setInterval(function() {
    location.reload();
}, 5000);
</script>
@endpush

@endsection
