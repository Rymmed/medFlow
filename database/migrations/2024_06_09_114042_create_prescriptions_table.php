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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_report_id')->nullable();
            $table->unsignedBigInteger('medicalRecord_id');
            $table->string('treatment');
            $table->text('description');
            $table->timestamps();

            $table->foreign('consultation_report_id')->references('id')->on('consultation_reports')->onDelete('set null');
            $table->foreign('medicalRecord_id')->references('id')->on('medical_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
