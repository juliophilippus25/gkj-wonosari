<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baptis extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'jemaat_id',
        'jadwal_id',
        'status_verifikasi',
        'status_kehadiran',
        'catatan',
    ];

    public function jemaat()
    {
        return $this->belongsTo(User::class, 'jemaat_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}
