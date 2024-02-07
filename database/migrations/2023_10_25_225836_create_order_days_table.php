<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('captain_id')->constrained('captains')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('trip_type_id')->constrained('trip_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('order_code');
            $table->string('total_price');
            $table->string('lat_user');
            $table->string('long_user');
            $table->string('address_now');
            $table->enum('status', ['done', 'waiting', 'pending', 'cancel', 'accepted'])->default('pending');
            $table->enum('payments', ['cash', 'masterCard', 'wallet']);
            $table->string('chat_id');
            $table->string('start_day')->nullable()->comment('بدايه اليوم');
            $table->string('end_day')->nullable()->comment('نهايه اليوم');
            $table->string('number_day')->nullable()->comment('عدد الايام');
            $table->string('start_time')->nullable()->comment('وقت البدايه');
            $table->string('commit')->nullable();
            $table->string('date_created')->nullable();
            $table->enum('type_duration', ['active', 'inactive'])->default('inactive');
            $table->foreignId('car_type_day_id')->constrained('car_type_days')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status_price',['premium','normal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_days');
    }
};
