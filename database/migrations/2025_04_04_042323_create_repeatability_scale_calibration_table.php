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
        Schema::create('repeatability_scale_calibrations', function (Blueprint $table) {
            $table->id();
            $table->uuid('calibration_uuid');
            $table->integer('weight');
            $table->decimal('average', 8, 2);
            $table->decimal('sd', 8, 1);
            $table->decimal('Urepeat', 8, 1);
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
        Schema::dropIfExists('repeatability_scale_calibrations');
    }
};
