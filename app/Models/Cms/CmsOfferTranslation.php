<?php
namespace App\Models\Cms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CmsOfferTranslation extends Model {
    use HasFactory;

    protected $table = "cms_offer_translations";
    protected $fillable = ['title', 'note_1', 'note_2', 'note_3', 'note_4', 'note_5', 'note_6', 'note_7', 'note_8', 'note_9', 'note_10'];
    public $timestamps = false;
}
