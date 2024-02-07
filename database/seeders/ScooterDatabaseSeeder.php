<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{ScooterMake,ScooterModel};
use Illuminate\Support\Facades\{DB,Schema};
class ScooterDatabaseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('scooter_makes')->truncate();
        DB::table('scooter_models')->truncate();
        $makesAndModels = [
            [
                'make' => ['name' => 'HAWA', 'status' => 1],
                'models' => [
                    ['name' => 'Marino Classic', 'status' => 1],
                    ['name' => 'Orbit', 'status' => 1],
                    ['name' => 'JET4', 'status' => 1],
                ],
            ],
            [
                'make' => ['name' => 'SYM', 'status' => 1],
                'models' => [
                    ['name' => '150', 'status' => 1],
                    ['name' => 'Fiddle 2', 'status' => 1],
                    ['name' => 'Semphoney SR', 'status' => 1],
                ],
            ],
            [
                'make' => ['name' => 'LML', 'status' => 1],
                'models' => [
                    ['name' => 'Fiddle 3', 'status' => 1],
                ],
            ],
            [
                'make' => ['name' => 'Kymco', 'status' => 1],
                'models' => [
                    ['name' => 'Urban S', 'status' => 1],
                    ['name' => 'Caffenero', 'status' => 1],
                    ['name' => 'Agility', 'status' => 1],
                ],
            ],
            [
                'make' => ['name' => 'Benelli', 'status' => 1],
                'models' => [
                    ['name' => 'Zafferano', 'status' => 1],
                ],
            ],
        ];

        foreach ($makesAndModels as $makeAndModels) {
            $make = ScooterMake::create(array_merge($makeAndModels['make'], ['created_at' => now(), 'updated_at' => now()]));

            foreach ($makeAndModels['models'] as $model) {
                ScooterModel::create(array_merge($model, ['scooter_make_id' => $make->id, 'created_at' => now(), 'updated_at' => now()]));
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}