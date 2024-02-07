<?php
namespace App\Services\Dashboard\General;
use App\Models\Hour;
class HourService {
    public function create($data) {
        return Hour::create($data);
    }
    public function update($hourId, $requestData) {
        $discount = Hour::findOrFail($hourId);
        $discount->fill($requestData);
        $discount->save();
        return $discount;
    }

    public function delete($hourId) {
        $discount = Hour::findOrFail($hourId);
        $discount->delete();
        return $discount;
    }
}