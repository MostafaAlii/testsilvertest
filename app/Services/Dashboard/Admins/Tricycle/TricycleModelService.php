<?php
namespace App\Services\Dashboard\Admins\Tricycle;
use App\Models\TricycleModel;
class TricycleModelService {
    public function create($data) {
        return TricycleModel::create($data);
    }
    
    public function update($tricycleModelId, $data) {
        $tricycleModel = TricycleModel::findOrFail($tricycleModelId);
        $tricycleModel->fill($data);
        $tricycleModel->save();
        return $tricycleModel;
    }

    public function delete($tricycleModelId) {
        $tricycleModel = TricycleModel::findOrFail($tricycleModelId);
        $tricycleModel->delete();
        return $tricycleModel;
    }

    public function updateStatus($tricycleModelId, $status) {
        $tricycleModel = TricycleModel::findOrFail($tricycleModelId);
        $tricycleModel->status = $status;
        $tricycleModel->save();
        return $tricycleModel;
    }
}