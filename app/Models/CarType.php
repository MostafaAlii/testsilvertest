<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'price_normal',
        'price_premium',
        'before_price_normal',
        'discount_price_normal',
        'discount_price_premium',
        'before_price_premium',
    ];

    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive()
    {
        return $this->whereStatus(true)->get();
    }

    public function hour_car_type() {
        return $this->belongsToMany(CarType::class, 'hour_car_type');
    }
}
