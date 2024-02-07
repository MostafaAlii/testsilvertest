<?php
namespace App\Services\Dashboard\Admins\Tricycle;
use App\Models\TricycleMake;
class TricycleMakeService {
    public function create($data) {
        return TricycleMake::create($data);
    }
    
    public function update($tricycleMakeId, $data) {
        $tricycleMake = TricycleMake::findOrFail($tricycleMakeId);
        $tricycleMake->fill($data);
        $tricycleMake->save();
        return $tricycleMake;
    }

    public function delete($tricycleMakeId) {
        $tricycleMake = TricycleMake::findOrFail($tricycleMakeId);
        $tricycleMake->delete();
        return $tricycleMake;
    }

    public function updateStatus($tricycleMakeId, $status) {
        $tricycleMake = TricycleMake::findOrFail($tricycleMakeId);
        $tricycleMake->status = $status;
        $tricycleMake->save();
        return $tricycleMake;
    }
}