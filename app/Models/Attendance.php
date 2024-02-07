<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model {
    use HasFactory;
    protected $table = 'attendances';
    protected $fillable = ['call_center_id','day','login', 'logout'];

    public function callCenter(): BelongsTo {
        return $this->belongsTo(related:Callcenter::class);
    }
}