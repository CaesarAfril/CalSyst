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
        Schema::create('temperature_calibration_assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->date('date');
            $table->uuid('asset_uuid');
            $table->decimal('avg_stdev_uut', 8, 3)->nullable();
            $table->decimal('u1', 8, 5)->nullable();
            $table->decimal('u2', 8, 5)->nullable();
            $table->decimal('u3', 8, 5)->nullable();
            $table->decimal('uc', 8, 5)->nullable();
            $table->decimal('veff', 8, 5)->nullable();
            $table->decimal('k', 8, 5)->nullable();
            $table->decimal('u95', 8, 5)->nullable();
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
        Schema::dropIfExists('temperature_calibration_assets');
    }
};
