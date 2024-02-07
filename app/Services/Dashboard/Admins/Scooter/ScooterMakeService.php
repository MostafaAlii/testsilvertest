<?php
namespace App\Services\Dashboard\Admins\Scooter;
use App\Models\ScooterMake;
class ScooterMakeService {
    public function create($data) {
        return ScooterMake::create($data);
    }
    
    public function update($scooterMakeId, $data) {
        $scooterMake = ScooterMake::findOrFail($scooterMakeId);
        $scooterMake->fill($data);
        $scooterMake->save();
        return $scooterMake;
    }

    public function delete($scooterMakeId) {
        $scooterMake = ScooterMake::findOrFail($scooterMakeId);
        $scooterMake->delete();
        return $scooterMake;
    }

    public function updateStatus($scooterMakeId, $status) {
        $scooterMake = ScooterMake::findOrFail($scooterMakeId);
        $scooterMake->status = $status;
        $scooterMake->save();
        return $scooterMake;
    }
}