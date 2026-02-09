@extends('layouts.admin')

@section('title', 'Chat - ' . $chat->subject)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="mb-4">
                <a href="{{ route('admin.chat.index') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Kembali ke Chat List
                </a>
            </div>

            {{-- Chat Header --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-1"><i class="bi bi-chat-dots"></i> {{ $chat->subject }}</h5>
                            <small>Dari: <strong>{{ $chat->user->nama }}</strong> ({{ $chat->user->email }})</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-{{ $chat->status === 'closed' ? 'danger' : ($chat->status === 'open' ? 'success' : 'warning') }}">
                                {{ ucfirst($chat->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-light border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Tanggal Dibuat:</strong> {{ $chat->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">
                                <strong>Terakhir Diupdate:</strong> {{ $chat->last_message_at ? $chat->last_message_at->format('d M Y H:i') : '-' }}
                            </p>
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

            {{-- Messages Container --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body" style="height: 500px; overflow-y: auto;" id="messagesContainer">
                    @forelse($messages as $message)
                    <div class="mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-1">
                                    <strong class="me-2">{{ $message->user->nama }}</strong>
                                    <small class="text-muted">
                                        {{ $message->created_at->format('d M Y H:i') }}
                                    </small>
                                    @if($message->user->role === 'admin')
                                    <span class="badge bg-success ms-2">Anda (Admin)</span>
                                    @else
                                    <span class="badge bg-secondary ms-2">User</span>
                                    @endif
                                </div>
                                <div class="bg-light p-3 rounded">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-5">Belum ada pesan.</p>
                    @endforelse
                </div>
            </div>

            {{-- Send Message Form --}}
            @if($chat->status !== 'closed')
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.chat.send-message', $chat->id) }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      name="message" placeholder="Tulis respon Anda..." rows="3" required></textarea>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-send"></i> Kirim Respon
                            </button>
                            @error('message')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    @if($chat->status !== 'closed')
                    <form action="{{ route('admin.chat.close', $chat->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pesan Penutupan (Opsional):</label>
                            <textarea name="message" class="form-control" rows="2" placeholder="Tulis pesan penutupan..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Yakin ingin menutup chat ini?')">
                            <i class="bi bi-x-circle"></i> Tutup Chat
                        </button>
                    </form>
                    @else
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle"></i> Chat ini telah ditutup pada {{ $chat->closed_at->format('d M Y H:i') }}.
                    </div>
                    @endif
                </div>

                {{-- Assign/Unassign --}}
                <div class="col-md-6">
                    @if($chat->admin_id === auth()->id())
                    <form action="{{ route('admin.chat.unassign', $chat->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="bi bi-person-x"></i> Lepas Chat (Unassign)
                        </button>
                    </form>
                    @elseif(!$chat->admin_id)
                    <form action="{{ route('admin.chat.assign', $chat->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">
                            <i class="bi bi-person-check"></i> Ambil Chat (Assign)
                        </button>
                    </form>
                    @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Chat ini sedang ditangani oleh: <strong>{{ $chat->admin->nama }}</strong>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="bi bi-info-circle"></i> Chat ini telah ditutup. Anda tidak bisa mengirim pesan.
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-scroll ke pesan terbaru
const messagesContainer = document.getElementById('messagesContainer');
if (messagesContainer) {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Auto-refresh messages setiap 3 detik
setInterval(function() {
    fetch('{{ route("admin.chat.get-messages", $chat->id) }}')
        .then(response => response.json())
        .then(data => {
            // Refresh page untuk load pesan terbaru
            location.reload();
        });
}, 3000);
</script>
@endpush

@endsection
