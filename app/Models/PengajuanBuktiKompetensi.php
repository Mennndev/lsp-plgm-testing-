<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanBuktiKompetensi extends Model
{
    protected $table = 'pengajuan_bukti_kompetensi';

    protected $fillable = [
        'pengajuan_skema_id',
        'kriteria_unjuk_kerja_id',
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
     * Relationship: belongs to kriteria unjuk kerja
     */
    public function kriteriaUnjukKerja()
    {
        return $this->belongsTo(KriteriaUnjukKerja::class);
    }
}
