<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTricycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'captain_id',
        'order_code',
        'total_price',
        'address_now',
        'address_going',
        'time_trips',
        'distance',
        'chat_id',
        'status',
        'payments',
        'lat_caption',
        'long_caption',
        'lat_user',
        'long_user',
        'lat_going',
        'long_going',
        'date_created',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function captain()
    {
        return $this->belongsTo(Captain::class, 'captain_id');
    }

    public function takingOrder()
    {
        return $this->hasOne(OrderTakingTricycle::class, 'order_tricycle_id');
    }


    public function canselOrder()
    {
        return $this->hasOne(OrderCanselTricycle::class, 'order_id');
    }


    public function status()
    {
        $result = "";
        switch ($this->status) {
            case 'done':
                $result = "تم اتمام الرحله بنجاح";
                break;
            case 'waiting':
                $result = "تم الوصول";
                break;
            case 'pending':
                $result = "تم طلب الرحله";
                break;
            case 'cancel':
                $result = "تم الغاء الرحله بنجاح";
                break;
            case 'accepted':
                $result = "بدأ الرحله";
                break;
            default:
                // Handle any other cases or provide a default action
                break;
        }
        return $result;
    }
}
