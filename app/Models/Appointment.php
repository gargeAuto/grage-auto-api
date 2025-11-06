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
        'engineer_id',
        'service',
        'selectedStart',
        'total_price',
        'new_price',
        'comments',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'customer_id');
    }
    public function engeener()
    {
        return $this->belongsTo(\App\Models\User::class, 'engineer_id');
    }
    public function service()
    {
        return $this->belongsToMany(\App\Models\Service::class, 'appointment_service');
    }
    protected $casts = [
        'service' => 'datetime',
    ];
}
