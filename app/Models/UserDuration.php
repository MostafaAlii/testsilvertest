<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_hour_id',
        'order_day_id',
        'type_order',
        'price',
        'value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
