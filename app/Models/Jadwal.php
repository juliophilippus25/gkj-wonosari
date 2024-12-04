<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'tanggal',
        'jam',
        'pendeta_id',
        'layanan_id'
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function pendeta(){
        return $this->belongsTo(User::class);
    }

    public function getIsExpiredAttribute()
    {
        return Carbon::today()->greaterThan($this->tanggal);
    }
}
