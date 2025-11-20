<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    protected $fillable = [
        'wording',
        'description',
        'delay',
    ];
    public function appointment()
    {
        return $this->belongsToMany(\App\Models\Appointment::class, 'appointment_service');
    }
}
