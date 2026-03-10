<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoursOpening extends Model
{
     protected $fillable = [
    'garage',
    'start_morning_date',
    'end_morning_date',
    'start_afternoon_date',
    'end_afternoon_date',
    'close',
  ];

}

