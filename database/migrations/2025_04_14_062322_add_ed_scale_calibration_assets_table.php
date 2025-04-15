<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scale_calibration_assets', function (Blueprint $table) {
            $table->date('expired_date')->default(DB::raw('CURRENT_DATE'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scale_calibration_assets', function (Blueprint $table) {
            $table->dropColumn('expired_date');
        });
    }
};
