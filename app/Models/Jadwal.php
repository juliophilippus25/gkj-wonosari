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
        'layanan_id',
        'jenis_bahasa',
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
        $waktuPelaksanaan = Carbon::parse($this->tanggal . ' ' . $this->jam);

        return Carbon::now()->greaterThan($waktuPelaksanaan);
    }

    public function baptis()
    {
        return $this->hasMany(Baptis::class);
    }

    public function sidhi()
    {
        return $this->hasMany(Sidhi::class);
    }

    public function katekisasi()
    {
        return $this->hasMany(Katekisasi::class);
    }
}
