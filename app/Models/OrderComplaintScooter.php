<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderComplaintScooter extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_scooter_id',
        'user_id',
        'captain_id',
        'type',
        'complaint',
    ];

    public function order_scooter()
    {
        return $this->belongsTo(OrderScooter::class, 'order_scooter');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function captain()
    {
        return $this->belongsTo(Caption::class, 'captain_id');
    }
}
