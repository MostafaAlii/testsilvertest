<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_bout',
        'number_kilometre',
        'name',
        'notes',
        'start_data',
        'end_data',
    ];
}
