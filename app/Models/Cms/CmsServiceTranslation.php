<?php

namespace App\Models\Cms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};
class CmsServiceTranslation extends Model {
    use HasFactory;

    protected $table = "cms_service_translations";
    protected $fillable = ['title', 'body', 'description', 'note_1', 'note_2', 'note_3', 'note_4', 'note_5'];
    public $timestamps = false;

    public function blog(): BelongsTo {
        return $this->belongsTo(CmsService::class);
    }
}