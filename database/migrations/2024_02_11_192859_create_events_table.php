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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('event_description');
            $table->boolean('isApproved')->default(false);
            $table->boolean('isCancelled')->default(false); 
            $table->timestamp('cancelled_at')->nullable();
            $table->string('event_status');
            $table->string('event_type');
            $table->string('event_age_group')->nullable();
            $table->string('event_gender_group')->nullable();
            $table->text('event_address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('event_picture')->nullable();
            $table->integer('event_capacity');
            $table->integer('event_number_of_participants')->default(0);
            $table->string('event_link')->nullable();
            $table->foreignId('creatorID')->constrained('users');
            $table->foreignId('adminID')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
