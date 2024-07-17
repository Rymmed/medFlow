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
       Schema::create('doctor_infos', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('doctor_id');
           $table->string('speciality')->nullable();
           $table->string('professional_card')->nullable();
           $table->json('days_of_week')->default("[]"); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
           $table->time('start_time')->default("08:00:00");
           $table->time('end_time')->default("18:00:00");;
           $table->string('office_phone_number')->nullable();
           $table->integer('consultation_duration')->nullable();
           $table->json('consultation_types')->default(json_encode([]));
           $table->string('online_fees')->nullable();
           $table->string('home_service_fees')->nullable();
           $table->string('in_person_fees')->nullable();
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
