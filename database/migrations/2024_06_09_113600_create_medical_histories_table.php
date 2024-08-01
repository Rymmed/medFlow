<?php

use App\Enums\MedicalHistSubtype;
use App\Enums\MedicalHistType;
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
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicalRecord_id');
            $table->string('title');
            $table->enum('type', MedicalHistType::getValues());
            $table->enum('subtype', MedicalHistSubtype::getValues());
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('medicalRecord_id')->references('id')->on('medical_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
