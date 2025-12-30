<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiAdministratif extends Model
{
    protected $table = 'bukti_administratif';

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
     * Relationship: has many pengajuan bukti administratif
     */
    public function pengajuanBuktiAdministratif()
    {
        return $this->hasMany(PengajuanBuktiAdministratif::class);
    }
}
