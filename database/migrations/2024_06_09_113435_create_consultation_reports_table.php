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
        Schema::create('consultation_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->datetime('consultation_date');
            $table->text('consultation_reason');
            $table->text('symptoms')->nullable();
            $table->text('vital_signs')->nullable();
            $table->text('diagnostic_hypotheses')->nullable();
            $table->text('final_diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_reports');
    }
};
