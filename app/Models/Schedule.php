<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'pendeta_id',
        'service_id'
    ];

    public function services()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'pendeta_id');
    }
}
