<?php
declare (strict_types = 1);
namespace App\Observers;
use App\Models\Callcenter;
class CallCenterObserver {
    public function created(Callcenter $callCenter): void {
        $callCenter->profile()->create([]);
    }
}