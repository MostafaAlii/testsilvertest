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
        Schema::table('images', function (Blueprint $table) {
            $table->integer('created_by_callcenter_id')->nullable();
            $table->integer('updated_by_callcenter_id')->nullable();
            $table->timestamp('created_at_callcenter')->nullable();
            $table->timestamp('updated_at_callcenter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('created_by_callcenter_id');
            $table->dropColumn('updated_by_callcenter_id');
            $table->dropColumn('created_at_callcenter');
            $table->dropColumn('updated_at_callcenter');
        });
    }
};