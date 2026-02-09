# Setup Midtrans Webhook untuk Payment Status Update

## Masalah yang Diperbaiki
Status pembayaran di aplikasi masih "Menunggu Pembayaran" padahal pembayaran sudah masuk ke Midtrans. Ini terjadi karena webhook Midtrans belum dikonfigurasi.

## Solusi

### 1. **Webhook Route Sudah Ditambahkan** ✅
Endpoint webhook sudah diimplementasikan di:
- **Route:** `POST /webhook/midtrans`
- **Controller:** `PembayaranController@notification`
- **URL Lengkap:** `https://yourdomain.com/webhook/midtrans`

### 2. **Auto-Check Status (Fallback)** ✅
Jika webhook belum terkonfigurasi, aplikasi akan:
- Otomatis check status pembayaran setiap 5 detik
- Update status secara real-time di frontend
- Reload halaman ketika pembayaran berhasil

### 3. **Setup Webhook di Midtrans Dashboard** (PENTING)

Untuk mengaktifkan notifikasi real-time, ikuti langkah ini:

#### A. Login ke Midtrans Dashboard
1. Buka https://dashboard.midtrans.com
2. Login dengan akun Anda
3. Pilih environment (Sandbox atau Production)

#### B. Konfigurasi Webhook
1. Buka **Settings** (Pengaturan) → **Webhook Configuration**
2. Atau buka **Configuration** → **HTTP Notification**
3. Masukkan URL webhook di field "HTTP Notification URL":
   ```
   https://yourdomain.com/webhook/midtrans
   ```

#### C. Test Webhook
1. Klik "Send Test" / "Test Notification"
2. Pastikan server menerima notifikasi (cek response)
3. Jika error, pastikan:
   - URL accessible dari internet
   - Tidak ada firewall yang memblokir
   - Server berjalan dengan baik

### 4. **Verify Webhook Signature**
Aplikasi sudah melakukan validasi signature untuk keamanan:
```php
$expectedSignature = hash(
    'sha512',
    $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
);

if ($signatureKey !== $expectedSignature) {
    abort(403, 'Invalid signature');
}
```

## Flow Pembayaran yang Benar

```
1. User Bayar Sekarang
   ↓
2. Generate Snap Token
   ↓
3. Buka Popup Midtrans
   ↓
4. Pembayaran Berhasil di Midtrans
   ↓
5. [WITH WEBHOOK] Midtrans POST ke /webhook/midtrans
   ↓
6. Status berubah instan menjadi 'success'
   
ATAU

5. [WITHOUT WEBHOOK] Auto-check status setiap 5 detik
   ↓
6. Status akan dideteksi dan berubah ke 'success'
```

## Testing di Environment Sandbox

Untuk testing pembayaran di sandbox:

1. **Virtual Account Number (VA):**
   - Bank BCA: komputer
   - Bank BNI: 112500
   - Bank Mandiri: 123456
   - Jumlah dapat berapa saja

2. **E-Wallet:**
   - GoPay, OVO, DANA, LinkAja bisa pakai nomor apa saja
   - Status akan pending sampai di-approve manual

3. **Approval Manual:**
   - Klik "Send Test" di dashboard untuk simulasi pembayaran sukses

## File-file yang Terkait

1. **Route:** `/routes/web.php` - Webhook endpoint
2. **Controller:** `/app/Http/Controllers/PembayaranController.php` - Notification handler
3. **Service:** `/app/Services/MidtransService.php` - Signature validation & status update
4. **View:** `/resources/views/pembayaran/show.blade.php` - Auto-check status client-side

## Checklist Setup

- [ ] Webhook route sudah aktif
- [ ] Webhook URL sudah dikonfigurasi di Midtrans Dashboard
- [ ] Webhook URL accessible dari internet (tidak localhost)
- [ ] Test webhook berhasil
- [ ] Payment status update dengan benar
- [ ] Production environment sudah setup

## Support

Jika webhook masih tidak bekerja:
1. Cek logs di `/storage/logs/laravel.log`
2. Pastikan server bisa akses https://api.midtrans.com
3. Verifikasi CSRF token tidak memblok webhook (sudah di-handle di route)
4. Tunggu 5-10 detik untuk auto-check status (fallback mechanism)

