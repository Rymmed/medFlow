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
       Schema::create('availabilities', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('doctor_id');
           $table->json('days_of_week')->default("[]"); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
           $table->time('start_time')->default("08:00:00");
           $table->time('end_time')->default("18:00:00");;
           $table->decimal('consultation_duration', 5, 2)->default('60');
           $table->timestamps();

           $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availability');
    }
};
