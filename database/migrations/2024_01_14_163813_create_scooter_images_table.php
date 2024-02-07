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
        Schema::create('scooter_images', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->enum('type', ['personal','scooter']);
            $table->enum('photo_type', [
                'personal_avatar',
                'id_photo_front',
                'id_photo_back',
                'criminal_record',
                'captain_license_front',
                'captain_license_back',
                
                'scooter_license_front',
                'scooter_license_back',
                'scooter_front',
                'scooter_back',
                'scooter_right',
                'scooter_left',
            ]);
            $table->enum('photo_status', ['accept', 'rejected', 'not_active'])->default('not_active');
            $table->string('reject_reson')->nullable();
            $table->morphs('imageable');
            $table->integer('scooter_id')->nullable();
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
        Schema::dropIfExists('scooter_images');
    }
};
