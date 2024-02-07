<?php
declare (strict_types = 1);
namespace App\Observers;
use App\Models\User;
class UserObserver {
    public function created(User $user): void {
        $user->profile()->create([]);

        $user->invite()->create([
            'user_id' => $user->id,
            'type' => 'user',
            'code_invite'=> str_replace(' ', '_', $user->name) . generateRandom(3),
            'data' => date('Y-m-d'),
        ]);
    }
}
