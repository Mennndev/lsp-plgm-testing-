<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanApl02 extends Model
{
    protected $table = 'pengajuan_apl02';

    protected $fillable = [
        'pengajuan_skema_id',
        'unit_kompetensi_id',
        'self_assessment',
    ];

    protected $casts = [
        'self_assessment' => 'array',
    ];

    // Relationships
    public function pengajuanSkema(): BelongsTo
    {
        return $this->belongsTo(PengajuanSkema::class);
    }

    public function unitKompetensi(): BelongsTo
    {
        return $this->belongsTo(UnitKompetensi::class);
    }
}
