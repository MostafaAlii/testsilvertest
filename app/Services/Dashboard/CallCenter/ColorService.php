<?php
namespace App\Services\Dashboard\CallCenter;
use App\Models\Color;
class ColorService {
    public function create($data) {
        return Color::create($data);
    }

    public function update($colorId, $data) {
        $color = Color::findOrFail($colorId);
        $color->fill($data);
        $color->save();
        return $color;
    }

    public function delete($colorId) {
        $color = Color::findOrFail($colorId);
        $color->delete();
        return $color;
    }
}