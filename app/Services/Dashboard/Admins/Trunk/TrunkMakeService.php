<?php
namespace App\Services\Dashboard\Admins\Trunk;
use App\Models\TrunkMake;
class TrunkMakeService {
    public function create($data) {
        return TrunkMake::create($data);
    }
    
    public function update($trunkMakeId, $data) {
        $trunkMake = TrunkMake::findOrFail($trunkMakeId);
        $trunkMake->fill($data);
        $trunkMake->save();
        return $trunkMake;
    }

    public function delete($trunkMakeId) {
        $trunkMake = TrunkMake::findOrFail($trunkMakeId);
        $trunkMake->delete();
        return $trunkMake;
    }

    public function updateStatus($trunkMakeId, $status) {
        $trunkMake = TrunkMake::findOrFail($trunkMakeId);
        $trunkMake->status = $status;
        $trunkMake->save();
        return $trunkMake;
    }
}