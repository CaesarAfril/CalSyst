<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scale_calibration_assets', function (Blueprint $table) {
            $table->string('approval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scale_calibration_assets', function (Blueprint $table) {
            $table->dropColumn('approval')->nullable(false)->change();
        });
    }
};