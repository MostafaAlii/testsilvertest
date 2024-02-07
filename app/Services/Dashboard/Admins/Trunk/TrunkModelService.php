<?php
namespace App\Services\Dashboard\Admins\Trunk;
use App\Models\TrunkModel;
class TrunkModelService {
    public function create($data) {
        return TrunkModel::create($data);
    }
    
    public function update($trunkModelId, $data) {
        $trunkModel = TrunkModel::findOrFail($trunkModelId);
        $trunkModel->fill($data);
        $trunkModel->save();
        return $trunkModel;
    }

    public function delete($trunkModelId) {
        $trunkModel = TrunkModel::findOrFail($trunkModelId);
        $trunkModel->delete();
        return $trunkModel;
    }

    public function updateStatus($trunkModelId, $status) {
        $trunkModel = TrunkModel::findOrFail($trunkModelId);
        $trunkModel->status = $status;
        $trunkModel->save();
        return $trunkModel;
    }
}