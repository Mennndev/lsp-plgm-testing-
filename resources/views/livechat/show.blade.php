@extends('layouts.app')

@section('title', 'Chat - ' . $chat->subject)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Header --}}
            <div class="mb-4">
                <a href="{{ route('chat.index') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Kembali ke Chat List
                </a>
            </div>

            {{-- Chat Info --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0"><i class="bi bi-chat-dots"></i> {{ $chat->subject }}</h5>
                            <small>Dibuat: {{ $chat->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-{{ $chat->status === 'closed' ? 'danger' : ($chat->status === 'open' ? 'success' : 'warning') }}">
                                {{ ucfirst($chat->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($chat->admin)
                <div class="card-body border-bottom bg-light">
                    <p class="mb-0">
                        <i class="bi bi-person-circle"></i> <strong>Admin yang Menangani:</strong> {{ $chat->admin->nama }}
                    </p>
                </div>
                @endif
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

            {{-- Messages --}}
            <div class="card shadow-sm mb-4" style="height: 500px; overflow-y: auto;" id="messagesContainer">
                <div class="card-body" id="messagesList">
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
                                    <span class="badge bg-info ms-2">Admin</span>
                                    @endif
                                </div>
                                <div class="bg-light p-2 rounded">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">Belum ada pesan.</p>
                    @endforelse
                </div>
            </div>

            {{-- Send Message Form --}}
            @if($chat->status !== 'closed')
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('chat.send-message', $chat->id) }}" method="POST" id="messageForm">
                        @csrf
                        <div class="input-group">
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      name="message" placeholder="Tulis pesan Anda..." rows="2" required></textarea>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-send"></i> Kirim
                            </button>
                            @error('message')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            {{-- Close Chat Button --}}
            <div class="text-center mt-4">
                <form action="{{ route('chat.close', $chat->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                            onclick="return confirm('Yakin ingin menutup chat ini?')">
                        <i class="bi bi-x-circle"></i> Tutup Chat
                    </button>
                </form>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="bi bi-info-circle"></i> Chat ini telah ditutup oleh admin pada {{ $chat->closed_at->format('d M Y H:i') }}.
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-scroll ke pesan terbaru
const messagesContainer = document.getElementById('messagesContainer');
messagesContainer.scrollTop = messagesContainer.scrollHeight;

// Auto-refresh messages setiap 3 detik
setInterval(function() {
    fetch('{{ route("chat.get-messages", $chat->id) }}')
        .then(response => response.json())
        .then(data => {
            // Check if there are new messages
            const currentMsgCount = document.querySelectorAll('#messagesList .mb-3').length;
            // Refresh page to load new messages
            location.reload();
        });
}, 3000);
</script>
@endpush

@endsection
