<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('captains', function (Blueprint $table) {
            $table->enum('status_caption_type', ['car', 'scooter', 'tricycle', 'trunk'])->change();
        });
        Schema::table('caption_activities', function (Blueprint $table) {
            $table->enum('status_caption_type', ['car', 'scooter', 'tricycle', 'trunk'])->change();
        });
    }

    public function down(): void {
        Schema::table('captains', function (Blueprint $table) {
            $table->enum('status_caption_type', ['car', 'scooter'])->change();
        });
        Schema::table('caption_activities', function (Blueprint $table) {
            $table->enum('status_caption_type', ['car', 'scooter'])->change();
        });
    }
};
