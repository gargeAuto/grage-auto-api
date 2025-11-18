<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
    
        'car_id',
        'service',
        'selectedStart',
        //'total_price',
        //'new_price',
        //'comments',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'customer_id');
    }
    public function engineer()
    {
        return $this->belongsToMany(\App\Models\User::class, 'users_appointments');
    }
    public function service()
    {
        return $this->belongsToMany(\App\Models\Service::class, 'appointment_service');
    }
        public function car()
    {
        return $this->belongsTo(\App\Models\Cars::class, 'car_id');
    }
   
}
