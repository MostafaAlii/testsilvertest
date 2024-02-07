<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCanselTricycle extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_tricycle_id',
        'user_id',
        'captain_id',
        'cansel',
        'type',
    ];

    public function order_scooter()
    {
        return $this->belongsTo(OrderTricycle::class,'order_tricycle_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function captain()
    {
        return $this->belongsTo(Caption::class,'captain_id');
    }
}
