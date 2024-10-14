<?php

use App\Enums\PatientArea;
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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->boolean('smoking')->default('0')->nullable();
            $table->boolean('alcohol')->default('0')->nullable();
            $table->enum('blood_group', \App\Enums\BloodGroup::getValues())->nullable();
            $table->enum('area', PatientArea::getValues())->nullable();
            $table->boolean('sedentary_lifestyle')->default('1');//0: active | 1: pas d'activité sportive
            $table->integer('temperature')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('oxygen_saturation')->nullable();

            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
