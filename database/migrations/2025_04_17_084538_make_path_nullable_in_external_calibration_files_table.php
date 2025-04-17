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
        Schema::table('external_calibration_files', function (Blueprint $table) {
            $table->string('path')->nullable()->change();
            $table->string('filename')->nullable()->change();
            $table->date('upload_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_calibration_files', function (Blueprint $table) {
            $table->string('path')->nullable(false)->change();
            $table->string('filename')->nullable(false)->change();
            $table->date('filename')->nullable(false)->change();
        });
    }
};