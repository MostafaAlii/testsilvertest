<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTakingScooter extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_scooter_id',
        'lat_caption',
        'long_caption',
    ];
}
