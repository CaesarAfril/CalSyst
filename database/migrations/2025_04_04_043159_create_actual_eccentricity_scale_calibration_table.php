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
        Schema::create('actual_eccentricity_scale_calibrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eccentricity_id');
            $table->decimal('shown', 8, 2);
            $table->decimal('correction', 8, 2);
            $table->decimal('absolute_correction', 8, 2);
            $table->timestamps();

            $table->foreign('eccentricity_id')->references('id')->on('eccentricity_scale_calibrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_eccentricity_scale_calibrations');
    }
};
