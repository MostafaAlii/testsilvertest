<?php

namespace Database\Seeders;

use App\Models\Bonus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('bonuses')->truncate();

        Bonus::create([
            'number_bout'=>fake()->numberBetween(10,50),
            'number_kilometre'=>fake()->numberBetween(50,150),
            'name'=>fake()->name(),
            'notes'=>fake()->paragraph,
            'start_data'=>Carbon::now(),
            'end_data'=>Carbon::now()->addMonth(),
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
