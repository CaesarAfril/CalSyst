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
        Schema::create('actual_repeatability_scale_calibrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repeatability_id');
            $table->decimal('shown', 8, 2);
            $table->decimal('correction', 8, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('repeatability_id')->references('id')->on('repeatability_scale_calibrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_repeatability_scale_calibrations');
    }
};
