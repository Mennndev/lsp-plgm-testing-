# 🚀 Panduan Setup Midtrans Production

## Langkah 1: Dapatkan Production Keys

1. Login ke [Midtrans Dashboard](https://dashboard.midtrans.com/)
2. **Toggle Environment** dari "Sandbox" ke **"Production"** (di kanan atas)
3. Masuk ke **Settings → Access Keys**
4. Copy:
   - **Server Key** (contoh: `Mid-server-xxxxxxxxxxxxx`)
   - **Client Key** (contoh: `Mid-client-xxxxxxxxxxxxx`)

## Langkah 2: Update File `.env`

Edit file `.env` di root project Anda:

```env
# Untuk Production (Live)
MIDTRANS_SERVER_KEY=Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=true
```

⚠️ **JANGAN commit file `.env` ke Git!**

## Langkah 3: Setup Webhook URL di Midtrans Dashboard

1. Di Midtrans Dashboard (Production mode)
2. Masuk ke **Settings → Configuration → Payment Notification URL**
3. Set Notification URL menjadi:
   ```
   https://yourdomain.com/api/midtrans/notification
   ```
4. Klik **Update**

## Langkah 4: Clear Config Cache

Setelah update `.env`, jalankan:

```bash
php artisan config:clear
php artisan config:cache
```

## Langkah 5: Testing

1. Buat pengajuan skema baru
2. Admin approve pengajuan
3. User klik "Bayar Sekarang"
4. Gunakan **real payment method** (tidak bisa pakai test cards)
5. Verifikasi pembayaran berhasil tercatat

## Perbedaan Sandbox vs Production

| Aspek | Sandbox | Production |
|-------|---------|-----------|
| Server Key | Prefix `SB-` | Prefix `Mid-` |
| Client Key | Prefix `SB-` | Prefix `Mid-` |
| Snap JS URL | `app.sandbox.midtrans.com` | `app.midtrans.com` |
| Payment Method | Test cards | Real payment |
| Transaction | Simulasi | Real money |

## Troubleshooting

### Pembayaran tidak tercatat?
- Pastikan webhook URL sudah didaftarkan di Midtrans Dashboard
- Cek log Laravel: `storage/logs/laravel.log`
- Cek Midtrans Dashboard → Transactions → Event History

### Signature Invalid?
- Pastikan `MIDTRANS_SERVER_KEY` di `.env` sama dengan di Dashboard
- Clear config cache: `php artisan config:clear`

### Snap popup tidak muncul?
- Pastikan `MIDTRANS_CLIENT_KEY` benar
- Cek console browser (F12) untuk error JavaScript

## Security Checklist

- ✅ File `.env` sudah ada di `.gitignore`
- ✅ Tidak hardcode keys di code
- ✅ Webhook menggunakan signature validation
- ✅ Gunakan HTTPS untuk production
- ✅ Server key tidak pernah terekspos ke frontend

## Rollback ke Sandbox (untuk testing)

Jika ingin kembali ke sandbox untuk testing:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

Kemudian:
```bash
php artisan config:clear
```

---

📞 **Bantuan:** Jika ada masalah, hubungi [Midtrans Support](https://midtrans.com/contact-us)
