<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alamat',
        'no_ktp',
        'foto_profile',
        'bidang_keahlian',
        'pengalaman_tahun',
        'riwayat_pendidikan',
        'sertifikat_path',
        'catatan',
    ];

    protected $casts = [
        'bidang_keahlian' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
