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
        Schema::create('user_durations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('order_hour_id')->nullable()->constrained('order_hours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('order_day_id')->nullable()->constrained('order_days')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('hour_id')->nullable()->constrained('hours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type_order',['hours','day']);
            $table->string('price');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_durations');
    }
};
