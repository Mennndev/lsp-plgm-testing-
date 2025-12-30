<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersyaratanDasar extends Model
{
    protected $table = 'persyaratan_dasar';

    protected $fillable = [
        'program_pelatihan_id',
        'nama_dokumen',
        'tipe_dokumen',
        'is_wajib',
        'urutan',
    ];

    protected $casts = [
        'is_wajib' => 'boolean',
    ];

    /**
     * Relationship: belongs to program pelatihan
     */
    public function programPelatihan()
    {
        return $this->belongsTo(ProgramPelatihan::class);
    }

    /**
     * Relationship: has many pengajuan persyaratan dasar
     */
    public function pengajuanPersyaratanDasar()
    {
        return $this->hasMany(PengajuanPersyaratanDasar::class);
    }
}
