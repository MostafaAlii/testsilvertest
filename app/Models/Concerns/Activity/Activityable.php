<?php
namespace App\Models\Concerns\Activity;
use App\Models\{Image, ImagesActivity};
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
trait Activityable {
    public static function bootActivityable() {
        static::updated(function (Model $model) {
            collect($model->getWantedChangedColumns($model))->each(function ($change) use ($model) {
                $model->saveChange($change);
            });
        });
    }

    protected function saveChange(ColumnChange $change) {
        $image = Image::find($this->getKey());
        if ($image) {
            $photoType = $image->photo_type;
            $this->activity()->create([
                'changed_column' => $change->column,
                'change_value_from' => $change->from,
                'change_value_to' => $change->to,
                'type' => $change->type,
                'photo_type' => $photoType,
                'admin_id' => auth()->guard('admin')?->id(),
                'call_center_id' => auth()->guard('call-center')?->id(),
                'image_id' => $this->getKey(),
            ]);
        }
    }


    protected function getWantedChangedColumns(Model $model) {
        return collect(
            array_diff(Arr::except($model->getChanges(), $this->ignoreActivityColumns()), $original = $model->getOriginal())
        )->map(function ($change, $column) use ($original) {
            return new ColumnChange($column, Arr::get($original, $column), $change, $this->getImageType($column), $this->getKey());
        });
    }

    protected function getImageType($column) {
        if ($column === 'type') {
            return $this->type;
        }
        return null;
    }

    public function activity() {
        return $this->morphMany(ImagesActivity::class, 'activitieable')->latest();
    }

    public function ignoreActivityColumns() {
        return 'updated_at';
    }
}