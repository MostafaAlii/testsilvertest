<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScooterModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'scooter_make_id'
    ];

    public function scooter_make()
    {
        return $this->belongsTo(ScooterMake::class, 'scooter_make_id');
    }


    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive() {
        return $this->whereStatus(true)->get();
    }
}