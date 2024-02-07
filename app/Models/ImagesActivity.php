<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ImagesActivity extends Model {
    use HasFactory;
    protected $table = 'images_activities';
    protected $fillable = [
        'activitieable_id','activitieable_type', 'type', 'photo_type','changed_column','change_value_from',
        'change_value_to','admin_id','call_center_id','image_id'
    ];

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function callCenter() {
        return $this->belongsTo(Callcenter::class, 'call_center_id');
    }

    public function image() {
        return $this->belongsTo(Image::class, 'image_id');
    }
}