<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveRentHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_type_id',
        'order_code',
        'total_price',
        'lat_user',
        'long_user',
        'status',
        'payments',
        'chat_id',
        'address_now',
        'data',
        'hours_from',
        'hour_id',
        'commit',
        'car_type_id',
        'status_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function trip_type()
    {
        return $this->belongsTo(TripType::class, 'trip_type_id');
    }
    public function hour()
    {
        return $this->belongsTo(Hour::class, 'hour_id');
    }
    public function car_type()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }
}
