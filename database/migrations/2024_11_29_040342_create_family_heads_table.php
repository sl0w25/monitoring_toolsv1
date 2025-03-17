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
        Schema::create('family_heads', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('ext_name')->nullable();
            $table->string('birthday');
            $table->string('age')->nullable();
            $table->string('birthplace');
            $table->string('gender');
            $table->string('civil_status');
            $table->string('mothers_maiden');
            $table->string('religion');
            $table->string('occupation')->nullable();
            $table->string('net_income')->nullable();
            $table->string('id_card')->nullable();
            $table->string('id_number')->nullable();
            $table->string('contact');
            $table->string('permanent_address');
            $table->string('4ps')->nullable();
            $table->string('ips')->nullable();
            $table->string('others')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_hired')->default(false);
            $table->boolean('validated_by')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_heads');
    }
};
