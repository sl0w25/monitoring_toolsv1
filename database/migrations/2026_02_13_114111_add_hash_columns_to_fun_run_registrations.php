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
          Schema::table('fun_run_registrations', function (Blueprint $table) {
                $table->string('dswd_id_hash')->unique();
                $table->string('qr_number_hash')->unique();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {
            //
        });
    }
};
