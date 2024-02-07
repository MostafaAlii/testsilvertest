<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->string('number_hours');
            $table->string('offer_price')->comment('السعر قبل الخصم');
            $table->string('discount_hours')->comment('السعر بعد الخصم');
            $table->string('price_hours');
            $table->string('price_premium')->nullable();
            $table->string('offer_price_premium')->nullable();
            $table->foreignId('category_car_id')->constrained('category_cars')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hours');
    }
};
