<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use Exception;
use Carbon\Carbon;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Generate Snap Token
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
                'phone' => $user->no_hp ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'SKEMA-' . $pembayaran->pengajuan_skema_id,
                    'price' => (int) $pembayaran->nominal,
                    'quantity' => 1,
                    'name' => 'Sertifikasi: ' . ($pembayaran->pengajuan->program->nama ?? 'Skema Sertifikasi'),
                ],
            ],
            'enabled_payments' => ['qris', 'gopay', 'bank_transfer'],
            'callbacks' => [
                'finish' => route('pembayaran.finish', $pembayaran->id),
            ],
            'expiry' => [
                'start_time' => Carbon::now()->format('Y-m-d H:i:s O'),
                'unit' => 'days',
                'duration' => 1,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $pembayaran->update([
                'snap_token' => $snapToken,
                'expired_at' => now()->addDay(),
            ]);

            return $snapToken;
        } catch (Exception $e) {
            Log::error('Midtrans Snap Error', ['error' => $e->getMessage()]);
            throw new Exception('Gagal membuat transaksi Midtrans');
        }
    }

    /**
     * Handle Webhook Midtrans
     */
    public function handleNotification(): array
    {
        $notification = new Notification();

        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $signatureKey = $notification->signature_key;

        // VALIDASI SIGNATURE
        $expectedSignature = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
        );

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans signature invalid', compact('orderId'));
            abort(403, 'Invalid signature');
        }

        $pembayaran = Pembayaran::where('order_id', $orderId)->first();

        if (! $pembayaran) {
            return ['success' => false, 'message' => 'Pembayaran tidak ditemukan'];
        }

        $pembayaran->update([
            'payment_type' => $notification->payment_type,
            'transaction_id' => $notification->transaction_id,
            'transaction_time' => $notification->transaction_time,
            'gross_amount' => $grossAmount,
            'payment_details' => json_encode($notification),
        ]);

        switch ($notification->transaction_status) {
            case 'capture':
            case 'settlement':
                $this->markSuccess($pembayaran);
                break;

            case 'pending':
                $pembayaran->update(['status' => 'processing']);
                break;

            case 'deny':
            case 'cancel':
                $pembayaran->update(['status' => 'failed']);
                break;

            case 'expire':
                $pembayaran->update(['status' => 'expired']);
                break;

            case 'refund':
                $pembayaran->update(['status' => 'refunded']);
                break;
        }

        return [
            'success' => true,
            'order_id' => $orderId,
            'status' => $notification->transaction_status,
        ];
    }

    private function markSuccess(Pembayaran $pembayaran): void
    {
        $pembayaran->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        $pembayaran->pengajuan->update([
            'status' => 'paid',
        ]);
    }

    public function checkStatus(string $orderId): array
    {
        return (array) Transaction::status($orderId);
    }

    public function cancel(string $orderId): array
    {
        return (array) Transaction::cancel($orderId);
    }
}
