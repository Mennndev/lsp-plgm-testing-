<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfesiTerkait extends Model
{
 protected $fillable = [
        'program_pelatihan_id',
        'nama',
        'icon'
    ];

    public function program()
    {
        return $this->belongsTo(ProgramPelatihan::class, 'program_pelatihan_id');
    }
}
