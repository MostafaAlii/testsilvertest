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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('order_code')->nullable();
            $table->string('ticket_code')->nullable();
            $table->text('subject')->nullable();
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->enum('status', ['close', 'open']);
            $table->foreignId('callcenter_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('assign_to_admin')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('assign_to_callcenter')->nullable()->constrained('callcenters')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};