<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaUnjukKerja extends Model
{
    protected $table = 'kriteria_unjuk_kerja';

    protected $fillable = [
        'elemen_kompetensi_id',
        'no_urut',
        'deskripsi',
    ];

    /**
     * Relationship: belongs to elemen kompetensi
     */
    public function elemenKompetensi()
    {
        return $this->belongsTo(ElemenKompetensi::class);
    }

    /**
     * Relationship: has many pengajuan bukti kompetensi
     */
    public function pengajuanBuktiKompetensi()
    {
        return $this->hasMany(PengajuanBuktiKompetensi::class);
    }
}
