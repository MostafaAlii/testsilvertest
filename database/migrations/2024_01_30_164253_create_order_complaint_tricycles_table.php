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
        Schema::create('order_complaint_tricycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_tricycle_id')->constrained('order_tricycles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('captain_id')->nullable()->constrained('captains')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type',['user','caption']);
            $table->text('complaint')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_complaint_tricycles');
    }
};
