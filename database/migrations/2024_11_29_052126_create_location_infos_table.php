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
        Schema::create('location_infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('region');
            $table->string('province');
            $table->string('municipality');
            $table->string('district')->nullable();
            $table->string('barangay');
            $table->string('ec');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_infos');
    }
};
