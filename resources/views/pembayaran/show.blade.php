@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Header --}}
            <div class="mb-4">
                <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Kembali ke Detail Pengajuan
                </a>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Info Pembayaran --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Detail Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="40%"><strong>Skema Sertifikasi</strong></td>
                            <td>{{ $pengajuan->program->nama ??  '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama Peserta</strong></td>
                            <td>{{ Auth::user()->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nominal Pembayaran</strong></td>
                            <td class="fs-4 fw-bold text-primary">
                                {{ $pembayaran->formatted_nominal ??  'Rp ' . number_format($pengajuan->program->harga ??  500000, 0, ',', '. ') }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="badge bg-{{ $pembayaran->status_badge_color ?? 'warning' }} fs-6">
                                    {{ $pembayaran->status_label ?? 'Menunggu Pembayaran' }}
                                </span>
                            </td>
                        </tr>
                        @if($pembayaran && $pembayaran->paid_at)
                        <tr>
                            <td><strong>Tanggal Bayar</strong></td>
                            <td>{{ $pembayaran->paid_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Tombol Bayar --}}
            @if(! $pembayaran || $pembayaran->canPay())
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-5">
                    <i class="bi bi-wallet2 text-primary" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">Siap untuk membayar? </h4>
                    <p class="text-muted">Klik tombol di bawah untuk melanjutkan pembayaran</p>

                    <button type="button" id="pay-button" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-credit-card me-2"></i> Bayar Sekarang
                    </button>

                    <div id="loading" class="d-none mt-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memproses pembayaran...</p>
                    </div>
                </div>
            </div>

            {{-- Metode Pembayaran yang Didukung --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Metode Pembayaran yang Didukung</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center g-3">
                        <div class="col-4 col-md-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia. svg/1200px-Bank_Central_Asia.svg.png" alt="BCA" class="img-fluid" style="max-height: 30px;">
                            <small class="d-block mt-1 text-muted">BCA</small>
                        </div>
                        <div class="col-4 col-md-2">
                            <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/1200px-BNI_logo.svg.png" alt="BNI" class="img-fluid" style="max-height: 30px;">
                            <small class="d-block mt-1 text-muted">BNI</small>
                        </div>
                        <div class="col-4 col-md-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/1200px-Bank_Mandiri_logo_2016.svg.png" alt="Mandiri" class="img-fluid" style="max-height:  30px;">
                            <small class="d-block mt-1 text-muted">Mandiri</small>
                        </div>
                        <div class="col-4 col-md-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/GoPay_logo.svg/1200px-GoPay_logo.svg.png" alt="GoPay" class="img-fluid" style="max-height: 30px;">
                            <small class="d-block mt-1 text-muted">GoPay</small>
                        </div>
                        <div class="col-4 col-md-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" alt="OVO" class="img-fluid" style="max-height: 30px;">
                            <small class="d-block mt-1 text-muted">OVO</small>
                        </div>
                        <div class="col-4 col-md-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Shopee_Pay_logo.svg/1200px-Shopee_Pay_logo.svg.png" alt="ShopeePay" class="img-fluid" style="max-height: 30px;">
                            <small class="d-block mt-1 text-muted">ShopeePay</small>
                        </div>
                    </div>
                    <p class="text-muted small mt-3 mb-0">
                        <i class="bi bi-shield-check"></i> Pembayaran diproses secara aman melalui Midtrans
                    </p>
                </div>
            </div>
            @endif

            {{-- Jika pembayaran sedang diproses --}}
            @if($pembayaran && $pembayaran->status === 'processing')
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-5">
                    <div class="spinner-border text-info mb-3" role="status" style="width: 3rem; height:  3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h4>Pembayaran Sedang Diproses</h4>
                    <p class="text-muted">Silakan selesaikan pembayaran Anda sesuai instruksi yang diberikan.</p>

                    @if($pembayaran->payment_details)
                        @if(isset($pembayaran->payment_details['va_numbers']))
                            <div class="alert alert-info text-start">
                                <strong>Virtual Account: </strong><br>
                                @foreach($pembayaran->payment_details['va_numbers'] as $va)
                                    {{ strtoupper($va['bank']) }}: <code class="fs-5">{{ $va['va_number'] }}</code><br>
                                @endforeach
                            </div>
                        @endif
                    @endif

                    @if($pembayaran->pdf_url)
                        <a href="{{ $pembayaran->pdf_url }}" target="_blank" class="btn btn-outline-primary">
                            <i class="bi bi-file-pdf"></i> Lihat Instruksi Pembayaran
                        </a>
                    @endif
                </div>
            </div>
            @endif

            {{-- Jika pembayaran berhasil --}}
            @if($pembayaran && $pembayaran->status === 'success')
            <div class="card shadow-sm border-success mb-4">
                <div class="card-body text-center py-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-success">Pembayaran Berhasil!</h4>
                    <p class="text-muted">Terima kasih, pembayaran Anda telah berhasil diproses. </p>
                    <p><strong>ID Transaksi:</strong> {{ $pembayaran->transaction_id }}</p>
                    <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="btn btn-primary">
                        Lihat Detail Pengajuan
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
{{-- Untuk Production, ganti dengan:  --}}
{{-- <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script> --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('pay-button');
    const loading = document.getElementById('loading');

    if (payButton) {
        payButton. addEventListener('click', function() {
            // Tampilkan loading
            payButton.classList.add('d-none');
            loading.classList.remove('d-none');

            // Request snap token dari server
            fetch('{{ route("pembayaran.process", $pengajuan->id) }}', {
                method: 'POST',
                headers:  {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response. json())
            .then(data => {
                if (data.success) {
                    // Tampilkan popup Midtrans
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Success:', result);
                            window.location.href = '{{ route("pembayaran.finish", $pembayaran->id ??  0) }}';
                        },
                        onPending: function(result) {
                            console.log('Pending:', result);
                            window.location.href = '{{ route("pembayaran.finish", $pembayaran->id ?? 0) }}';
                        },
                        onError: function(result) {
                            console.log('Error:', result);
                            alert('Pembayaran gagal.  Silakan coba lagi.');
                            payButton.classList.remove('d-none');
                            loading. classList.add('d-none');
                        },
                        onClose: function() {
                            console.log('Popup ditutup');
                            payButton.classList.remove('d-none');
                            loading.classList.add('d-none');
                        }
                    });
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                    payButton.classList. remove('d-none');
                    loading.classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                payButton.classList.remove('d-none');
                loading.classList.add('d-none');
            });
        });
    }
});
</script>
@endpush
