<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptainScooter extends Model {
    use HasFactory;
    protected $table = "captain_scooters";
    protected $fillable = [
        'captain_id',
        'scooter_make_id',
        'scooter_model_id',
        'scooter_number',
        'scooter_color',
        'scooter_year',
    ];

    public function captain() {
        return $this->belongsTo(Captain::class,'captain_id');
    }

    public function scooter_make() {
        return $this->belongsTo(ScooterMake::class, 'scooter_make_id');
    }

    public function scooter_model() {
        return $this->belongsTo(ScooterModel::class, 'scooter_model_id');
    }

    public function scooterImages() {
        return $this->hasMany(ScooterImage::class, 'imageable_id');
    }
}
