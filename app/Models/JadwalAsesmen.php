<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalAsesmen extends Model
{
    protected $table = 'jadwal_asesmen';

    protected $fillable = [
        'pengajuan_skema_id',
        'asesor_id',
        'created_by',
        'updated_by',
        'tanggal_mulai',
        'tanggal_selesai',
        'mode_asesmen',
        'lokasi',
        'tautan_meeting',
        'status',
        'catatan',
        'reschedule_count',
        'last_rescheduled_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'last_rescheduled_at' => 'datetime',
    ];

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanSkema::class, 'pengajuan_skema_id');
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'Terjadwal',
            'completed' => 'Selesai',
            'postponed' => 'Ditunda',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'scheduled' => 'primary',
            'completed' => 'success',
            'postponed' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
