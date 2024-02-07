<?php
namespace Database\Seeders;
use App\Models\Callcenter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Schema};
class CallcenterSeeder extends Seeder {
    public function run() {
        Schema::disableForeignKeyConstraints();
        DB::table('callcenters')->delete();
        Callcenter::factory()->count(20)->create();
        Schema::enableForeignKeyConstraints();
    }
}