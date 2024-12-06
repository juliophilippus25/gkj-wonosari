<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilJemaat extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'wilayah_id',
        'nik',
        'nama',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'ayah',
        'ibu',
        'jenis_kelamin',
    ];

    public function wilayah(){
        return $this->belongsTo(Wilayah::class);
    }
}
