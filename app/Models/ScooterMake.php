<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScooterMake extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function status() {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive() {
        return $this->whereStatus(true)->get();
    }

    public function scooterModel()
    {
        return $this->hasMany(ScooterModel::class,'scooter_make_id');
    }
}