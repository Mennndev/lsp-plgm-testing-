<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanAsesor extends Model
{
    protected $table = 'pengajuan_asesor';

    protected $fillable = [
        'pengajuan_skema_id',
        'asesor_id',
        'role',
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

