<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSelfAssessment extends Model
{
    protected $table = 'pengajuan_self_assessments';

    protected $fillable = [
        'pengajuan_skema_id',
        'kriteria_unjuk_kerja_id',
        'nilai',
    ];

    public function kuk()
{
    return $this->belongsTo(KriteriaUnjukKerja::class, 'kriteria_unjuk_kerja_id');
}

}
