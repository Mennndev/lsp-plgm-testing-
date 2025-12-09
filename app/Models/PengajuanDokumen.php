<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanDokumen extends Model
{
    protected $table = 'pengajuan_dokumen';

    protected $fillable = [
        'pengajuan_skema_id',
        'jenis_dokumen',
        'nama_file',
        'path',
        'ukuran',
    ];

    // Relationship
    public function pengajuanSkema(): BelongsTo
    {
        return $this->belongsTo(PengajuanSkema::class);
    }

    // Helper method to get file size in human readable format
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->ukuran;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
