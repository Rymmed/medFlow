<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('lastName');
            $table->string('firstName');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('role')->default('super-admin');
            $table->string('avatar')->nullable();
            $table->string('city')->nullable();
            $table->string('town')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('cin_number')->nullable();
            $table->string('speciality')->nullable();
            $table->string('registration_number')->nullable();
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
