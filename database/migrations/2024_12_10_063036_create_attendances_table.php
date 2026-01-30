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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('bene_id');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('ext_name')->nullable();
            $table->string('sex');
            $table->string('status')->nullable();
            $table->string('is_hired')->nullable();
            $table->string('w_listed')->nullable();
            $table->string('qr_number');
            $table->string('amount');
            $table->string('time_in');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistances');
    }
};
