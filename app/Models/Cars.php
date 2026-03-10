<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $fillable = [
        'user_id',
        'immat',
        'km',
        'make',
        'model',
        'year'
    ];
       
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
