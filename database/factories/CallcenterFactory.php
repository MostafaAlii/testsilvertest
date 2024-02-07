<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\{Agent, Country, Admin};
class CallcenterFactory extends Factory {
    public function definition(): array {
        $adminId = $this->faker->boolean(70) ? Admin::active()->pluck('id')->random() : null;
        $agentId = !$adminId ? Agent::active()->pluck('id')->random() : null;
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('123123'), 
            'remember_token' => Str::random(10),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'country_id' => Country::active()->random()->id,
            'admin_id' => $adminId,
            'agent_id' => $agentId,
        ];
    }

    public function unverified() {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}