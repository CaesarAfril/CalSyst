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
        Schema::create('actual_display_calibration', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->decimal('set_temp', 8, 2);
            $table->decimal('standar1', 8, 2);
            $table->decimal('standar2', 8, 2);
            $table->decimal('standar3', 8, 2);
            $table->decimal('standar4', 8, 2);
            $table->decimal('standar5', 8, 2);
            $table->decimal('aktual1', 8, 2);
            $table->decimal('aktual2', 8, 2);
            $table->decimal('aktual3', 8, 2);
            $table->decimal('aktual4', 8, 2);
            $table->decimal('aktual5', 8, 2);
            $table->decimal('avgprt', 8, 2);
            $table->decimal('stdevprt', 8, 2);
            $table->decimal('avguut', 8, 2);
            $table->decimal('stdevuut', 8, 2);
            $table->decimal('uprt', 8, 2);
            $table->uuid('display_calibration_uuid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('display_calibration_uuid')->references('uuid')->on('display_calibration_assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_display_calibration');
    }
};
