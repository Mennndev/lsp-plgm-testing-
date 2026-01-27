<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanAsesorAssessment extends Model
{
    protected $table = 'pengajuan_asesor_assessments';

    protected $fillable = [
        'pengajuan_skema_id',
        'kriteria_unjuk_kerja_id',
        'asesor_id',
        'nilai',
        'catatan',
    ];

    public function pengajuan()
{
    return $this->belongsTo(PengajuanSkema::class, 'pengajuan_skema_id');
}

public function asesor()
{
    return $this->belongsTo(User::class, 'asesor_id');
}

}
