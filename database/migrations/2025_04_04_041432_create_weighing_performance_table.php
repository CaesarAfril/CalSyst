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
        Schema::create('weighing_performance_calibrations', function (Blueprint $table) {
            $table->id();
            $table->uuid('calibration_uuid');
            $table->integer('total');
            $table->integer('weight_1');
            $table->integer('weight_2');
            $table->decimal('show', 8, 5);
            $table->decimal('correction', 8, 5);
            $table->decimal('Uweightstd', 8, 6);
            $table->decimal('Ubouyancy', 18, 14);
            $table->decimal('Uc', 18, 12);
            $table->decimal('U95', 18, 12);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('calibration_uuid')->references('uuid')->on('scale_calibration_assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weighing_performance_calibrations');
    }
};
