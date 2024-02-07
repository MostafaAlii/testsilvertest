<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('images_activities', function (Blueprint $table) {
            $table->morphs('activitieable');
            $table->string('changed_column');
            $table->text('change_value_from')->nullable();
            $table->text('change_value_to')->nullable();
            $table->text('type')->nullable();
            $table->text('photo_type')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('call_center_id')->nullable()->constrained('callcenters')->cascadeOnDelete();
            $table->foreignId('image_id')->nullable()->constrained('images')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('images_activities');
    }
};
