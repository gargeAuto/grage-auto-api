<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
        protected $fillable = [
        'customer',
        'garage',
        'engineer',
        'service',
        'total_price',
        'new_price',
        'comments',
    ];
    
    public function customer()
     {
        return $this->belongsTo(\App\Models\User::class, 'customer_id');
    }
    public function service()
{
    return $this->belongsToMany(\App\Models\Service::class, 'appointment_service');
}
}
