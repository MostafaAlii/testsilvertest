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
        Schema::table('captain_profiles', function (Blueprint $table) {
           $table->string('point')->default(0);
        });

        Schema::table('settings', function (Blueprint $table) {
           $table->string('price_day_premium')->nullable();
            $table->string('kilo_price_premium')->nullable();

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('captain_profiles', function (Blueprint $table) {
           $table->dropColumn('point');
        });


        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('price_day_premium');
            $table->dropColumn('kilo_price_premium');
        });


    }
};
