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
        'nik',
        'nama',
        'tanggal_lahir',
        'tempat_lahir',
        'no_hp',
        'ayah',
        'ibu',
        'jenis_kelamin',
    ];
}
