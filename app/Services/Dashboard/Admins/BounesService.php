<?php
namespace App\Services\Dashboard\Admins;
use App\Models\CaptionBonus;
class BounesService {

    public function delete($bounesId) {
        $bounes = CaptionBonus::findOrFail($bounesId);
        $bounes->delete();
        return $bounes;
    }
}