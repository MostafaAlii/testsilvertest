<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrunkModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'trunk_make_id'
    ];

    public function trunk_make()
    {
        return $this->belongsTo(TrunkMake::class, 'trunk_make_id');
    }


    public function status()
    {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive() {
        return $this->whereStatus(true)->get();
    }
}