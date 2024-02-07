<?php
declare (strict_types = 1);
namespace App\Observers;
use App\Models\Captain;
use Faker\Factory as Faker;
class CaptainObserver {
    public function created(Captain $captain): void {
        $faker = Faker::create();
        $captain->profile()->create([]);
        $captain->invite()->create([
            'captain_id' => $captain->id,
            'type' => 'caption',
            'code_invite'=> str_replace(' ', '_', $captain->name) . generateRandom(3),
            'data' => date('Y-m-d'),
        ]);
        $captain->captainActivity()->create([
            'status_captain_work' => 'waiting',
            'captain_id' => $captain->id,
            'longitude' => $faker->longitude(),
            'latitude' => $faker->latitude(),
            'status_caption_type' => $captain->status_caption_type,
        ]);
    }
}
