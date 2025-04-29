<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('temperature_calibration_assets', function (Blueprint $table) {
            $table->timestamp('approval_date')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temperature_calibration_assets', function (Blueprint $table) {
            $table->dropColumn('approval_date')->nullable(false)->change();
        });
    }
};