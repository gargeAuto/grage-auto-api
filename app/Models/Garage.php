<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
  protected $fillable = [
    'id',
    'name',
    'adress',
    'postal_code',
    'city',
    'email',
    'engineer_quantity',
    'sercice_price',
  ];
}
