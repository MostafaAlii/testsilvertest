<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cms_service_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('body');
            $table->longText('description')->nullable();
            $table->longText('note_1')->nullable();
            $table->longText('note_2')->nullable();
            $table->longText('note_3')->nullable();
            $table->longText('note_4')->nullable();
            $table->longText('note_5')->nullable();
            $table->string('locale');
            $table->unique(['cms_service_id', 'locale']);
            $table->index(['title', 'locale']);
            $table->foreignId('cms_service_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cms_service_translations');
    }
};