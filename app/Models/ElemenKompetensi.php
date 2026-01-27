<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElemenKompetensi extends Model
{
    protected $table = 'elemen_kompetensis';

    protected $fillable = [
        'unit_kompetensi_id',
        'no_urut',
        'nama_elemen',
    ];

    public function unitKompetensi()
    {
        return $this->belongsTo(UnitKompetensi::class);
    }

    public function kriteriaUnjukKerja()
    {
        return $this->hasMany(KriteriaUnjukKerja::class)->orderBy('no_urut');
    }

    public function unit()
    {
        return $this->belongsTo(UnitKompetensi::class, 'unit_kompetensi_id');
    }
}
