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
        Schema::table('external_calibrations', function (Blueprint $table) {
            $table->date('expired_date');
            $table->dropColumn('path');
            $table->dropColumn('filename');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_calibrations', function (Blueprint $table) {
            $table->dropColumn('expired_date');
            $table->string('path');
            $table->string('filename');
        });
    }
};