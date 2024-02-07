<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanselOrderHoursDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_day_id',
        'order_hour_id',
        'cansel',
        'type',
        'user_id',
        'captain_id',
    ];
}
