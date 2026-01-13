<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use Exception;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans. server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Buat Snap Token untuk pembayaran
     */
    public function createSnapToken(Pembayaran $pembayaran, User $user): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $pembayaran->order_id,
                'gross_amount' => (int) $pembayaran->nominal,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email' => $user->email,
                'phone' => $user->no_hp ??  '',
            ],
            'item_details' => [
                [
                    'id' => 'SKEMA-' . $pembayaran->pengajuan_skema_id,
                    'price' => (int) $pembayaran->nominal,
                    'quantity' => 1,
                    'name' => 'Sertifikasi:  ' . ($pembayaran->pengajuan->program->nama ?? 'Skema Sertifikasi'),
                ],
            ],
            'callbacks' => [
                'finish' => route('pembayaran.finish', $pembayaran->id),
            ],
            'expiry' => [
                'start_time' => date('Y-m-d H:i: s O'),
                'unit' => 'days',
                'duration' => 1, // 1 hari expired
            ],
        ];

        try {
            $snapToken = Snap:: getSnapToken($params);

            // Simpan snap token
            $pembayaran->update([
                'snap_token' => $snapToken,
                'expired_at' => now()->addDay(),
            ]);

            return $snapToken;
        } catch (Exception $e) {
            throw new Exception('Gagal membuat transaksi:  ' . $e->getMessage());
        }
    }

    /**
     * Handle notification dari Midtrans (webhook)
     */
    public function handleNotification(): array
    {
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $paymentType = $notification->payment_type;
        $fraudStatus = $notification->fraud_status ??  null;
        $transactionId = $notification->transaction_id;

        $pembayaran = Pembayaran::where('order_id', $orderId)->first();

        if (! $pembayaran) {
            return [
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan',
            ];
        }

        // Update payment details
        $paymentDetails = [
            'payment_type' => $paymentType,
            'transaction_id' => $transactionId,
            'transaction_time' => $notification->transaction_time ??  null,
            'gross_amount' => $notification->gross_amount ??  null,
        ];

        // Tambahkan VA number jika ada
        if (isset($notification->va_numbers)) {
            $paymentDetails['va_numbers'] = $notification->va_numbers;
        }

        // Tambahkan payment code jika ada (untuk convenience store)
        if (isset($notification->payment_code)) {
            $paymentDetails['payment_code'] = $notification->payment_code;
        }

        // Update pembayaran
        $pembayaran->update([
            'payment_type' => $paymentType,
            'transaction_id' => $transactionId,
            'transaction_status' => $transactionStatus,
            'payment_details' => $paymentDetails,
            'pdf_url' => $notification->pdf_url ??  null,
        ]);

        // Handle berdasarkan status
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $this->setSuccess($pembayaran);
            }
        } elseif ($transactionStatus == 'settlement') {
            $this->setSuccess($pembayaran);
        } elseif ($transactionStatus == 'pending') {
            $pembayaran->update(['status' => 'processing']);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel') {
            $pembayaran->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'expire') {
            $pembayaran->update(['status' => 'expired']);
        } elseif ($transactionStatus == 'refund') {
            $pembayaran->update(['status' => 'refunded']);
        }

        return [
            'success' => true,
            'message' => 'Notification handled',
            'order_id' => $orderId,
            'status' => $transactionStatus,
        ];
    }

    /**
     * Set pembayaran sukses
     */
    private function setSuccess(Pembayaran $pembayaran): void
    {
        $pembayaran->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        // Update status pengajuan menjadi 'paid'
        $pembayaran->pengajuan->update([
            'status' => 'paid',
        ]);

        // Kirim notifikasi ke user
        NotificationService::send(
            $pembayaran->user,
            'Pembayaran Berhasil',
            "Pembayaran untuk skema \"{$pembayaran->pengajuan->program->nama}\" berhasil.  Silakan menunggu jadwal asesmen.",
            [
                'type' => 'success',
                'icon' => 'bi-check-circle-fill',
                'link' => route('pengajuan.show', $pembayaran->pengajuan_skema_id),
            ]
        );
    }

    /**
     * Cek status transaksi di Midtrans
     */
    public function checkStatus(string $orderId): array
    {
        try {
            $status = Transaction::status($orderId);
            return (array) $status;
        } catch (Exception $e) {
            throw new Exception('Gagal cek status:  ' . $e->getMessage());
        }
    }

    /**
     * Cancel transaksi
     */
    public function cancel(string $orderId): array
    {
        try {
            $cancel = Transaction::cancel($orderId);
            return (array) $cancel;
        } catch (Exception $e) {
            throw new Exception('Gagal cancel transaksi: ' .  $e->getMessage());
        }
    }
}
