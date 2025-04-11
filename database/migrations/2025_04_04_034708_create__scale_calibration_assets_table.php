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
        Schema::create('scale_calibration_assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('asset_uuid');
            $table->string('certificate_number');
            $table->date('date');
            $table->decimal('initial_temp', 8, 2);
            $table->decimal('final_temp', 8, 2);
            $table->decimal('initial_rh', 8, 2);
            $table->decimal('final_rh', 8, 2);
            $table->decimal('max_weight', 8, 2);
            $table->decimal('max_scale', 8, 2);
            $table->decimal('scale_resolution', 8, 5);
            $table->integer('scale_class');
            $table->decimal('weight_resolution', 8, 1);
            $table->decimal('weight_max', 8, 4);
            $table->decimal('weight_min', 8, 6);
            $table->integer('k');
            $table->decimal('avg_dev_repeatability', 8, 1);
            $table->decimal('UDrift_weight', 18, 12);
            $table->decimal('Ureadability', 18, 12);
            $table->decimal('U95%', 8, 2);
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
        Schema::dropIfExists('scale_calibration_assets');
    }
};
