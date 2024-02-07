<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSaveRend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'save_rent_day_id',
        'save_rent_hour_id',
        'notify_status',
        'order_day_id',
        'order_hour_id',
    ];
}
