<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidhi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'jemaat_id',
        'jadwal_id',
        'status_verifikasi',
        'status_kehadiran',
        'catatan',
    ];

    public function profilJemaat()
    {
        return $this->belongsTo(ProfilJemaat::class,'jemaat_id', 'user_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}
