<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UnitKompetensi;
use App\Models\ProfesiTerkait;
use App\Models\Pendaftaran;

class ProgramPelatihan extends Model
{
    protected $fillable = [
        'kode_skema',
        'nama',
        'slug',
        'kategori',
        'kategori_slug',
        'rujukan_skkni',
        'jumlah_unit',
        'estimasi_biaya',
        'mata_uang',
        'masa_berlaku',
        'deskripsi_singkat',
        'ringkasan',
        'persyaratan_peserta',
        'metode_asesmen',
        'gambar',
        'file_panduan',
        'is_published',
    ];

    public function units()
    {
        return $this->hasMany(UnitKompetensi::class)->orderBy('no_urut');
    }

    public function profesiTerkait()
    {
        return $this->hasMany(ProfesiTerkait::class);
    }
    public function pendaftarans()
{
    return $this->hasMany(
        Pendaftaran::class,
        'skema',        // FK di pendaftarans
        'kode_skema'    // PK di program_pelatihans
    );
}

    public function persyaratanDasar()
    {
        return $this->hasMany(PersyaratanDasar::class)->orderBy('urutan');
    }

    public function buktiAdministratif()
    {
        return $this->hasMany(BuktiAdministratif::class)->orderBy('urutan');
    }

    public function buktiPortofolioTemplate()
    {
        return $this->hasMany(BuktiPortofolioTemplate::class)->orderBy('urutan');
    }

    public function asesors()
{
    return $this->belongsToMany(User::class, 'program_asesor', 'program_pelatihan_id', 'asesor_id');
}

    

}
