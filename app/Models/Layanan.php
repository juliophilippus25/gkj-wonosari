<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'id';

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
