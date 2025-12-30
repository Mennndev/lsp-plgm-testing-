<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanBuktiAdministratif extends Model
{
    protected $table = 'pengajuan_bukti_administratif';

    protected $fillable = [
        'pengajuan_skema_id',
        'bukti_administratif_id',
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
     * Relationship: belongs to bukti administratif
     */
    public function buktiAdministratif()
    {
        return $this->belongsTo(BuktiAdministratif::class);
    }
}
