<?php

namespace Database\Seeders;

use App\Models\SubscriptionCaption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SubscriptionCaptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('subscription_captions')->truncate();
        for ($i = 0; $i < 5; $i++) {
            SubscriptionCaption::create([
                'name_ar' => fake()->name(),
                'name_en' => fake()->name(),
                'price' => fake()->numberBetween(120, 350),
                'type' => fake()->randomElement(['month', 'week', 'day']),
                'notes_en' => fake()->paragraph(),
                'notes_ar' => fake()->paragraph(),
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
