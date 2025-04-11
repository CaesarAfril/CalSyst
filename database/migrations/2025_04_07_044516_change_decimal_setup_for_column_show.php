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
        Schema::table('weighing_performance_calibrations', function (Blueprint $table) {
            $table->decimal('show', 10, 5)->change();
        });
        Schema::table('actual_repeatability_scale_calibrations', function (Blueprint $table) {
            $table->decimal('shown', 10, 5)->change();
        });
        Schema::table('actual_eccentricity_scale_calibrations', function (Blueprint $table) {
            $table->decimal('shown', 10, 5)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weighing_performance_calibrations', function (Blueprint $table) {
            $table->decimal('show', 8, 5)->change();
        });
        Schema::table('actual_repeatability_scale_calibrations', function (Blueprint $table) {
            $table->decimal('shown', 8, 5)->change();
        });
        Schema::table('actual_eccentricity_scale_calibrations', function (Blueprint $table) {
            $table->decimal('shown', 8, 5)->change();
        });
    }
};
