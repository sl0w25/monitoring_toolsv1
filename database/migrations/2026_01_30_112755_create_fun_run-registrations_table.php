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
        Schema::create('fun_run_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('ext_name')->nullable();
            $table->string('division');
            $table->string('section');
            $table->string('contact_number');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_number');
            $table->string('race_category');
            $table->string('health_consent_form'); // file path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fun_run_registrations');
    }
};
