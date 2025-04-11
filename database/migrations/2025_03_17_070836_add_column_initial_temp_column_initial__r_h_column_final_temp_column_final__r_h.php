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
        Schema::table('temperature_calibration_assets', function (Blueprint $table) {
            $table->string('certificate_number')->after('uuid');
            $table->decimal('initial_temp', 8, 1)->after('asset_uuid');
            $table->decimal('final_temp', 8, 1)->after('initial_temp');
            $table->decimal('initial_rh', 8, 1)->after('final_temp');
            $table->decimal('final_rh', 8, 1)->after('initial_rh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temperature_calibration_assets', function (Blueprint $table) {
            $table->dropColumn('certificate_number');
            $table->dropColumn('initial_temp');
            $table->dropColumn('final_temp');
            $table->dropColumn('initial_rh');
            $table->dropColumn('final_rh');
        });
    }
};
