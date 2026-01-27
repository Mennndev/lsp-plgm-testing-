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

    public function elemen(){
        return $this->belongsTo(ElemenKompetensi::class, 'elemen_kompetensi_id');
    }

    /**
     * Relationship: has many pengajuan bukti kompetensi
     */
    public function pengajuanBuktiKompetensi()
    {
        return $this->hasMany(PengajuanBuktiKompetensi::class);
    }

    public function buktiKompetensis()
{
    return $this->hasMany(PengajuanBuktiKompetensi::class, 'kriteria_unjuk_kerja_id');
}

}
