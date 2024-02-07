<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('car_types', function (Blueprint $table) {
            $table->string('before_price_normal')->nullable();
            $table->string('discount_price_normal')->nullable();

            $table->string('discount_price_premium')->nullable();
            $table->string('before_price_premium')->nullable();
        });

        \App\Models\CarType::where('id', 1)->update([
            'before_price_normal' => 150,
            'discount_price_normal' => 50,
            'discount_price_premium' => 250,
            'before_price_premium' => 50,
        ]);
        \App\Models\CarType::where('id', 2)->update([
            'before_price_normal' => 250,
            'discount_price_normal' => 50,
            'discount_price_premium' => 350,
            'before_price_premium' => 50,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_types', function (Blueprint $table) {
            //
        });
    }
};
