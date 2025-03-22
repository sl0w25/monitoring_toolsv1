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
        Schema::create('tarlacs', function (Blueprint $table) {
            $table->id();
            $table->string('municipality');
            $table->string('absent')->nullable();
            $table->string('present')->nullable();
            $table->string('is_hired')->nullable();
            $table->string('w_list')->nullable();
            $table->string('bene')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarlacs');
    }
};
