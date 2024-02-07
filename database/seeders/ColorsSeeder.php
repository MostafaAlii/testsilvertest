<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ColorsSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['name' => 'أحمر'],
            ['name' => 'أزرق'],
            ['name' => 'أخضر'],
            ['name' => 'أصفر'],
            ['name' => 'برتقالي'],
        ];

        DB::table('colors')->insert($colors);
    }
}
