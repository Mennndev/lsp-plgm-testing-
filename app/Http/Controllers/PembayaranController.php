<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\PengajuanSkema;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class PembayaranController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Tampilkan halaman pembayaran
     */
    public function show($pengajuanId)
    {
        $pengajuan = PengajuanSkema::with(['program', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->findOrFail($pengajuanId);

        if (!in_array($pengajuan->status, ['approved', 'paid'])) {
            return redirect()->route('pengajuan.show', $pengajuanId)
                ->with('error', 'Pengajuan belum disetujui.');
        }

        $pembayaran = $pengajuan->pembayaran;

        // Update nominal pembayaran jika berbeda dengan estimasi_biaya program
        if ($pembayaran && $pengajuan->program && $pembayaran->nominal != $pengajuan->program->estimasi_biaya) {
            $pembayaran->nominal = $pengajuan->program->estimasi_biaya;
            $pembayaran->save();
        }

        // Jika sudah bayar, redirect ke detail pengajuan
        if ($pembayaran && $pembayaran->status === 'success') {
            return redirect()->route('pengajuan.show', $pengajuanId)
                ->with('success', 'Pembayaran sudah berhasil.');
        }

        return view('pembayaran.show', [
            'pengajuan' => $pengajuan,
            'pembayaran' => $pembayaran,
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    /**
     * Proses pembayaran - Generate Snap Token
     */
    public function process($pengajuanId)
    {
        $pengajuan = PengajuanSkema::with(['program', 'pembayaran'])
            ->where('user_id', Auth:: id())
            ->findOrFail($pengajuanId);

        if ($pengajuan->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Pengajuan belum disetujui.'
            ], 400);
        }

        $pembayaran = $pengajuan->pembayaran;

        // Cek apakah sudah ada snap token yang valid
        if ($pembayaran && $pembayaran->snap_token && $pembayaran->canPay()) {
            // Cek apakah token masih valid (belum expired)
            if ($pembayaran->expired_at && $pembayaran->expired_at > now()) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $pembayaran->snap_token,
                ]);
            }

            // Jika expired, buat order_id baru
            $pembayaran->update([
                'order_id' => Pembayaran::generateOrderId(),
                'status' => 'pending',
            ]);
        }

        // Jika belum ada pembayaran, buat baru
        if (! $pembayaran) {
            $pembayaran = Pembayaran::create([
                'pengajuan_skema_id' => $pengajuan->id,
                'user_id' => Auth:: id(),
                'order_id' => Pembayaran:: generateOrderId(),
                'nominal' => $pengajuan->program->estimasi_biaya ??  500000,
                'status' => 'pending',
            ]);
        }

        try {
            $snapToken = $this->midtransService->createSnapToken($pembayaran, Auth::user());

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Callback setelah pembayaran selesai (dari Midtrans Snap)
     */
    public function finish(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        // Redirect ke halaman detail pengajuan
        return redirect()->route('pengajuan.show', $pembayaran->pengajuan_skema_id)
            ->with('info', 'Pembayaran sedang diproses.  Status akan diupdate otomatis.');
    }

    /**
     * Handle notification dari Midtrans (webhook)
     */
    public function notification(Request $request)
    {
        try {
            $result = $this->midtransService->handleNotification();

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cek status pembayaran
     */
    public function checkStatus($pengajuanId)
    {
        $pengajuan = PengajuanSkema::with('pembayaran')
            ->where('user_id', Auth::id())
            ->findOrFail($pengajuanId);

        $pembayaran = $pengajuan->pembayaran;

        if (! $pembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan.',
            ], 404);
        }

        // Cek ke Midtrans untuk update status
        if (in_array($pembayaran->status, ['pending', 'processing']) && $pembayaran->order_id) {
            try {
                $status = $this->midtransService->checkStatus($pembayaran->order_id);
                
                // Update status berdasarkan response dari Midtrans
                if (isset($status['transaction_status'])) {
                    $transactionStatus = $status['transaction_status'];
                    
                    // Update payment details
                    $pembayaran->update([
                        'payment_type' => $status['payment_type'] ?? $pembayaran->payment_type,
                        'transaction_id' => $status['transaction_id'] ?? $pembayaran->transaction_id,
                        'transaction_status' => $transactionStatus,
                    ]);
                    
                    // Update status based on transaction status
                    switch ($transactionStatus) {
                        case 'capture':
                        case 'settlement':
                            $pembayaran->update([
                                'status' => 'success',
                                'paid_at' => now(),
                            ]);
                            $pembayaran->pengajuan->update(['status' => 'paid']);
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
                    }
                }

                return response()->json([
                    'success' => true,
                    'status' => $pembayaran->fresh()->status,
                    'status_label' => $pembayaran->fresh()->status_label,
                    'midtrans_status' => $status,
                ]);
            } catch (Exception $e) {
                // Ignore error, return current status
                \Log::error('Error checking payment status: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'status' => $pembayaran->status,
            'status_label' => $pembayaran->status_label,
        ]);
    }

    /**
     * Reset/Buat pembayaran baru
     */
    public function reset($pengajuanId)
    {
        $pengajuan = PengajuanSkema::with(['program', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->findOrFail($pengajuanId);

        if ($pengajuan->status !== 'approved') {
            return redirect()->back()
                ->with('error', 'Pengajuan belum disetujui.');
        }

        $pembayaran = $pengajuan->pembayaran;

        // Update pembayaran lama jika ada
        if ($pembayaran) {
            $pembayaran->update([
                'order_id' => Pembayaran::generateOrderId(),
                'status' => 'pending',
                'transaction_id' => null,
                'transaction_status' => null,
                'snap_token' => null,
                'pdf_url' => null,
                'payment_details' => null,
                'paid_at' => null,
                'expired_at' => null,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Pembayaran telah direset. Silakan lakukan pembayaran ulang.');
    }
}
