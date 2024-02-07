<?php
namespace App\Services\Dashboard\Admins\Scooter;
use App\Models\ScooterModel;
class ScooterModelService {
    public function create($data) {
        return ScooterModel::create($data);
    }
    
    public function update($scooterModelId, $data) {
        $scooterModel = ScooterModel::findOrFail($scooterModelId);
        $scooterModel->fill($data);
        $scooterModel->save();
        return $scooterModel;
    }

    public function delete($scooterModelId) {
        $scooterModel = ScooterModel::findOrFail($scooterModelId);
        $scooterModel->delete();
        return $scooterModel;
    }

    public function updateStatus($scooterModelId, $status) {
        $scooterModel = ScooterModel::findOrFail($scooterModelId);
        $scooterModel->status = $status;
        $scooterModel->save();
        return $scooterModel;
    }
}