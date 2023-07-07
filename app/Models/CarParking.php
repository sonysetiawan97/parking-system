<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarParking extends Model
{
    use HasFactory;

    protected $table = 'car_parking';

    protected $fillable = [
        'unique_code',
        'car_number_plate',
        'time_in',
        'time_out',
        'price',
        'status_parking'
    ];
}
