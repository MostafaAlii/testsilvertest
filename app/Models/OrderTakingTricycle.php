<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTakingTricycle extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_tricycle_id',
        'lat_caption',
        'long_caption',
    ];
}
