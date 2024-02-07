<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarTypeDay extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'price_normal',
        'price_premium',
    ];

    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive()
    {
        return $this->whereStatus(true)->get();
    }

}
