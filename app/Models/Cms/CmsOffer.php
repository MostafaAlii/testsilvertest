<?php
namespace App\Models\Cms;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};
class CmsOffer extends Model {
    use HasFactory, Translatable;
    protected $table = "cms_offers";
    protected $fillable = ['status','admin_id', 'price', 'plan_type'];
    protected $with = ['translations'];
    public $translatedAttributes = ['title', 'note_1', 'note_2', 'note_3', 'note_4', 'note_5', 'note_6', 'note_7', 'note_8', 'note_9', 'note_10'];
    public $timestamps = true;

    public function admin(): BelongsTo {
        return $this->belongsTo(Admin::class);
    }

    public function status() {
        return $this->status ? 'Active' : 'No Active';
    }

    public function scopeActive() {
        return $this->whereStatus(true)->get();
    }
}
