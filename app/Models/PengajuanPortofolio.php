<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPortfolio extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_portfolio';

    protected $fillable = [
        'pengajuan_skema_id',
        'unit_kompetensi_id',
        'nama_file',
        'path',
        'ukuran',
        'tipe_file',
        'deskripsi',
    ];

    public function pengajuanSkema()
    {
        return $this->belongsTo(PengajuanSkema::class);
    }

    public function unitKompetensi()
    {
        return $this->belongsTo(UnitKompetensi::class);
    }

    // Helper untuk format ukuran file
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->ukuran;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }
}
