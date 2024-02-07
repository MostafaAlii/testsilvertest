<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InviteFriend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'captain_id',
        'type',
        'code_invite',
        'data',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function captain()
    {
        return $this->belongsTo(Captain::class,'captain_id');
    }
}
