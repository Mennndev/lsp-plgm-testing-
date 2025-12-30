<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPersyaratanDasar extends Model
{
    protected $table = 'pengajuan_persyaratan_dasar';

    protected $fillable = [
        'pengajuan_skema_id',
        'persyaratan_dasar_id',
        'nama_file',
        'path',
        'ukuran',
    ];

    /**
     * Relationship: belongs to pengajuan skema
     */
    public function pengajuanSkema()
    {
        return $this->belongsTo(PengajuanSkema::class);
    }

    /**
     * Relationship: belongs to persyaratan dasar
     */
    public function persyaratanDasar()
    {
        return $this->belongsTo(PersyaratanDasar::class);
    }
}
