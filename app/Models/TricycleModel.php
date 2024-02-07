<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TricycleModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'tricycle_make_id'
    ];

    public function tricycle_make()
    {
        return $this->belongsTo(TricycleMake::class, 'tricycle_make_id');
    }


    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive() {
        return $this->whereStatus(true)->get();
    }
}
