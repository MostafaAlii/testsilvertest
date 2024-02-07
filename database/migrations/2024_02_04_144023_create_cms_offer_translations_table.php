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
        Schema::create('cms_offer_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('note_1')->nullable();
            $table->longText('note_2')->nullable();
            $table->longText('note_3')->nullable();
            $table->longText('note_4')->nullable();
            $table->longText('note_5')->nullable();
            $table->longText('note_6')->nullable();
            $table->longText('note_7')->nullable();
            $table->longText('note_8')->nullable();
            $table->longText('note_9')->nullable();
            $table->longText('note_10')->nullable();
            $table->string('locale');
            $table->unique(['cms_offer_id', 'locale']);
            $table->index(['title', 'locale']);
            $table->foreignId('cms_offer_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_offer_translations');
    }
};
