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
        Schema::create('otp_messages', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['caption','user']);
            $table->enum('status',['new','forget']);
            $table->string('code');
            $table->string('date')->default(\Illuminate\Support\Carbon::now()->format('Y-m-d'));
            $table->string('phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_messages');
    }
};
