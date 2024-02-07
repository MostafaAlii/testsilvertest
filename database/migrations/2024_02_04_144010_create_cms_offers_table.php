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
        Schema::create('cms_offers', function (Blueprint $table) {
            $table->id();
            $table->string('price')->nullable();
            $table->enum('plan_type', ['monthly', 'annuel', 'quarterly'])->default('monthly');
            $table->boolean('status')->default(true);
            $table->foreignId('admin_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_offers');
    }
};
