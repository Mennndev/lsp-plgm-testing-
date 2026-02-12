<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormulirAsesmen extends Model
{
    protected $table = 'formulir_asesmen';

    protected $fillable = [
        'pengajuan_skema_id',
        'asesor_id',
        'jenis_formulir',
        'data',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Relationship: belongs to PengajuanSkema
     */
    public function pengajuanSkema(): BelongsTo
    {
        return $this->belongsTo(PengajuanSkema::class, 'pengajuan_skema_id');
    }

    /**
     * Relationship: belongs to User (asesor)
     */
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }
}
