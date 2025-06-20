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
            $table->integer('paid');
            $table->integer('unpaid');
            $table->integer('w_listed');
            $table->integer('bene');
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
