@extends('layouts.dashboard')

@section('title', 'Live Chat')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-12">
            {{-- Header --}}
            <div class="mb-4">
                <h2><i class="bi bi-chat-dots"></i> Live Chat</h2>
                <p class="text-muted">Hubungi admin kami untuk menjawab pertanyaan Anda</p>
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

            {{-- Tombol Buat Chat Baru --}}
            <div class="mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newChatModal">
                    <i class="bi bi-plus-circle me-2"></i> Mulai Chat Baru
                </button>
            </div>

            {{-- Chat List --}}
            @if($chats->count() > 0)
            <div class="row">
                @foreach($chats as $chat)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 chat-card" style="cursor: pointer;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="card-title mb-1">{{ $chat->subject ?? 'Chat' }}</h6>
                                    <small class="text-muted">{{ $chat->created_at->format('d M Y H:i') }}</small>
                                </div>
                                <span class="badge bg-{{ $chat->status === 'closed' ? 'danger' : ($chat->status === 'open' ? 'success' : 'warning') }}">
                                    {{ ucfirst($chat->status) }}
                                </span>
                            </div>

                            <p class="card-text small text-muted text-truncate">
                                {{ $chat->last_message ?? '-' }}
                            </p>

                            @if($chat->admin)
                            <p class="small mb-2">
                                <i class="bi bi-person-circle"></i> Admin: <strong>{{ $chat->admin->nama }}</strong>
                            </p>
                            @endif

                            <div class="mt-3">
                                <a href="{{ route('chat.show', $chat->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-box-arrow-right"></i> Buka
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $chats->links() }}
            </div>
            @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Anda belum membuat chat apapun. Klik tombol "Mulai Chat Baru" untuk memulai percakapan.
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Buat Chat Baru --}}
<div class="modal fade" id="newChatModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mulai Chat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('chat.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="subject">Subjek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                               id="subject" name="subject" placeholder="Contoh: Pertanyaan tentang pembayaran" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="message">Pesan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="4" placeholder="Tulis pesan Anda..." required></textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Kirim Chat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-refresh chat list setiap 5 detik, tapi jangan reload saat modal terbuka
const refreshInterval = setInterval(function() {
    const modal = document.getElementById('newChatModal');
    if (modal && modal.classList.contains('show')) {
        return;
    }
    location.reload();
}, 5000);
</script>
@endpush

@endsection
