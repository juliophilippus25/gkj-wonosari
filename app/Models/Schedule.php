<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
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

    // Relasi ke Registration
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function getIsExpiredAttribute()
    {
        return Carbon::today()->greaterThan($this->date);
    }
}
