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
        Schema::create('family_infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('ext_name')->nullable();
            $table->string('relation');
            $table->string('birthday');
            $table->string('age')->nullable();
            $table->string('gender');
            $table->string('eductional_attainment');
            $table->string('occupation')->nullable();
            $table->string('vulnerability_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_infos');
    }
};
