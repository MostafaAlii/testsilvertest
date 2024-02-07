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
        Schema::create('save_rent_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('trip_type_id')->constrained('trip_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('car_type_day_id')->constrained('car_type_days')->cascadeOnDelete()->cascadeOnUpdate();
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
            $table->enum('status_price',['premium','normal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('save_rent_days');
    }
};
