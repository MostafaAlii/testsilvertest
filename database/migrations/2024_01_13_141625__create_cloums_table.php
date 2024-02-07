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
        Schema::table('captains', function (Blueprint $table) {
           $table->enum('status_caption_type',['car','scooter'])->default('car');
        });
        Schema::table('caption_activities', function (Blueprint $table) {
           $table->enum('status_caption_type',['car','scooter'])->default('car');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('captains', function (Blueprint $table) {
            $table->dropColumn('status_caption_type');
        });
        Schema::table('caption_activities', function (Blueprint $table) {
            $table->dropColumn('status_caption_type');
        });
    }
};
