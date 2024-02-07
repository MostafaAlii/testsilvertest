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
        Schema::create('order_tricycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('captain_id')->constrained('captains')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('order_code');
            $table->string('total_price');
            $table->string('address_now');
            $table->string('address_going');
            $table->string('time_trips');
            $table->string('distance');
            $table->string('chat_id');
            $table->enum('status', ['done', 'waiting', 'pending', 'cancel', 'accepted'])->default('pending');
            $table->enum('payments', ['cash', 'masterCard', 'wallet']);
            $table->string('lat_caption')->nullable();
            $table->string('long_caption')->nullable();
            $table->string('lat_user')->nullable();
            $table->string('long_user')->nullable();
            $table->string('lat_going')->nullable();
            $table->string('long_going')->nullable();
            $table->string('date_created')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tricycles');
    }
};
