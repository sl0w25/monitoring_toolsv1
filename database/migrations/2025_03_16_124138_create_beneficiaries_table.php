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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('bene_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('ext_name')->nullable();
            $table->string('birth_month');
            $table->string('birth_day');
            $table->string('birth_year');
            $table->string('sex');
            $table->string('barangay');
            $table->string('psgc_city');
            $table->string('city');
            $table->string('province');
            $table->string('type_of_assistance');
            $table->string('amount');
            $table->string('philsys_number');
            $table->string('beneficiary_unique_id');
            $table->string('contact_number');
            $table->string('target_sector');
            $table->string('sub_category');
            $table->string('civil_status');
            $table->string('qr_number');
            $table->string('is_hired');
            $table->string('status');
            $table->strig('ml_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
