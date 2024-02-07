<?php

namespace Database\Seeders;

use App\Models\CarTypeDay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CarTypeDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('car_type_days')->truncate();

        CarTypeDay::create([
            'name' => 'سيدان',
            'status' => true,
            'price_normal' => 250,
            'price_premium' => 100,
    
        ]);

        CarTypeDay::create([
            'name' => 'Suv',
            'status' => true,
            'price_normal' => 350,
            'price_premium' => 200,
        ]);



        Schema::enableForeignKeyConstraints();
    }
}
