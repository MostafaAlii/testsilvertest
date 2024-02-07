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
        Schema::create('cansel_order_hours_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_day_id')->nullable()->constrained('order_days')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('order_hour_id')->nullable()->constrained('order_hours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('cansel');
            $table->enum('type',['user','caption']);
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('captain_id')->nullable()->constrained('captains')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cansel_order_hours_days');
    }
};
