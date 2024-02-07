<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptionSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'captain_id',
        'subscription_caption_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function captain()
    {
        return $this->belongsTo(Captain::class,'captain_id');
    }
    public function subscription_caption()
    {
        return $this->belongsTo(SubscriptionCaption::class,'subscription_caption_id');
    }
}
