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
        Schema::create('caption_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->constrained('captains')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('subscription_caption_id')->constrained('subscription_captions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('start_date');
            $table->string('end_date');
            $table->enum('status',['active','inactive','waiting']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caption_subscriptions');
    }
};
