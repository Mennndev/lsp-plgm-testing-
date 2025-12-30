<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanBuktiPortofolio extends Model
{
    protected $table = 'pengajuan_bukti_portofolio';

    protected $fillable = [
        'pengajuan_skema_id',
        'bukti_portofolio_template_id',
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
     * Relationship: belongs to bukti portofolio template
     */
    public function buktiPortofolioTemplate()
    {
        return $this->belongsTo(BuktiPortofolioTemplate::class);
    }
}
