<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainTricycle extends Model
{
    protected $table = "captain_tricycles";
    protected $fillable = [
        'captain_id',
        'tricycle_make_id',
        'tricycle_model_id',
        'tricycle_number',
        'tricycle_color',
        'tricycle_year',
    ];

    public function captain() {
        return $this->belongsTo(Captain::class,'captain_id');
    }

    public function tricycle_make() {
        return $this->belongsTo(TricycleMake::class, 'tricycle_make_id');
    }

    public function tricycle_model() {
        return $this->belongsTo(TricycleModel::class, 'tricycle_model_id');
    }

    public function tricycleImages() {
        return $this->hasMany(TricycleImage::class, 'imageable_id', 'id');
    }
}
