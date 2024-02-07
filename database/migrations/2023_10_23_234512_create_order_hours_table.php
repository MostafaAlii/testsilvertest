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
        Schema::create('order_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('captain_id')->constrained('captains')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('trip_type_id')->constrained('trip_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('hour_id')->constrained('hours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('order_code');
            $table->string('total_price');
            $table->string('lat_user');
            $table->string('long_user');
            $table->enum('status', ['done', 'waiting', 'pending', 'cancel', 'accepted'])->default('pending');
            $table->enum('payments', ['cash', 'masterCard', 'wallet']);
            $table->string('chat_id');
            $table->string('address_now');
            $table->string('data');
            $table->string('hours_from');
            $table->string('commit')->nullable();
            $table->string('date_created')->nullable();
            $table->foreignId('car_type_id')->constrained('car_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status_price',['premium','normal']);
            $table->enum('type_duration', ['active', 'inactive'])->default('inactive');
            $table->string('time_duration')->nullable();
            for ($i = 1; $i <= 5; $i++) {
                $table->string('notes'.$i)->nullable();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_hours');
    }
};
