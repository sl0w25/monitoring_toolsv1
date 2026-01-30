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
            $table->string('municipality');
            $table->string('province');
            $table->string('prov_psgc');
            $table->string('city_psgc');
            $table->string('barangay_psgc');
            $table->string('type_of_assistance')->nullable();
            $table->string('amount')->nullable();
            $table->string('philsys_number')->nullable();
            $table->string('beneficiary_unique_id')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('target_sector')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('qr_number')->nullable();
            $table->boolean('paid')->default(false);
            $table->boolean('w_listed')->default(false);
            $table->string('status')->nullable();
            $table->integer('validated_by')->nullable();
            $table->string('ml_user')->nullable();
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
