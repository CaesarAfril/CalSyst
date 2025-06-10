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
        Schema::table('abf_validation', function (Blueprint $table) {
            $table->uuid('machine_uuid')->nullable();
            $table->foreign('machine_uuid')->references('uuid')->on('validation_assets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abf_validation', function (Blueprint $table) {
            $table->dropForeign('machine_uuid');
            $table->dropColumn('machine_uuid');
        });
    }
};