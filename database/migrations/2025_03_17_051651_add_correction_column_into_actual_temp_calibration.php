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
        Schema::table('actual_temperature_calibration', function (Blueprint $table) {
            $table->decimal('correction', 8, 2)->after('stdevuut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actual_temperature_calibration', function (Blueprint $table) {
            $table->dropColumn('correction');
        });
    }
};
