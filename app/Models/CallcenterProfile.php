<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CallcenterProfile extends BaseModel {
    protected $table = 'callcenter_profiles';
    protected $fillable = ['bio','callcenter_id', 'uuid'];
    public $timestamps = false;
    public function owner(): BelongsTo {
        return $this->belongsTo(related:Callcenter::class, foreignKey:'callcenter_id');
    }
}