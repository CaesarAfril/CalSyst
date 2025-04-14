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
        Schema::create('external_calibrations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->date('date');
            $table->uuid('asset_uuid');
            $table->string('path')->nullable();
            $table->string('filename')->nullable();
            $table->string('status')->nullable();
            $table->date('next_calibration_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_uuid')->references('uuid')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_calibrations');
    }
};