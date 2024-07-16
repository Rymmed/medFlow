<?php

use App\Enums\ConsultationType;
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
        Schema::create('consultation_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_info_id');
            $table->enum('type', ConsultationType::getValues());
            $table->string('fees');
            $table->integer('duration');
            $table->timestamps();

            $table->foreign('doctor_info_id')->references('id')->on('doctor_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_infos');
    }
};
