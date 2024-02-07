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
        Schema::create('captain_scooters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->constrained('captains')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('scooter_make_id')->nullable()->constrained('scooter_makes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('scooter_model_id')->nullable()->constrained('scooter_models')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('scooter', ['master', 'general'])->default('general');
            $table->string('scooter_number')->nullable();
            $table->string('scooter_color')->nullable();
            $table->year('scooter_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('captain_scooters');
    }
};
