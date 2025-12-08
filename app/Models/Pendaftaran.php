<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    // App\Models\Pendaftaran.php
protected $fillable = [
  'user_id',
  'email',
  'jenis_kelamin',
  'tempat_lahir',
  'tanggal_lahir',
  'alamat',
  'kota',
  'provinsi',
  'pendidikan',
  'pekerjaan',
  'instansi',
  'skema',
  'jadwal',
  'no_ktp',
  'ktp_path',
  'ttd_path',
  'setuju',
];


    protected $casts = [
        'tanggal_lahir' => 'date',
        'setuju'        => 'boolean',
    ];

    // Relasi ke user (kalau mau dipakai)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function program()
{
    return $this->belongsTo(
        ProgramPelatihan::class,
        'skema',        // FK di tabel pendaftarans
        'kode_skema'    // PK unik di tabel program_pelatihans
    );
}

}
