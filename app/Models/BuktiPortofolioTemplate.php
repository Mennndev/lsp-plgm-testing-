<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPortofolioTemplate extends Model
{
    protected $table = 'bukti_portofolio_template';

    protected $fillable = [
        'program_pelatihan_id',
        'nama_dokumen',
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
     * Relationship: has many pengajuan bukti portofolio
     */
    public function pengajuanBuktiPortofolio()
    {
        return $this->hasMany(PengajuanBuktiPortofolio::class);
    }
}
