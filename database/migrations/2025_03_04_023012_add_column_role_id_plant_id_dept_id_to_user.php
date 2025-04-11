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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('role_uuid')->after('password');
            $table->uuid('plant_uuid')->after('role_uuid');
            $table->uuid('dept_uuid')->after('plant_uuid');

            $table->foreign('role_uuid')->references('uuid')->on('role')->onDelete('cascade');
            $table->foreign('plant_uuid')->references('uuid')->on('plant')->onDelete('cascade');
            $table->foreign('dept_uuid')->references('uuid')->on('department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_uuid');
            $table->dropColumn('plant_uuid');
            $table->dropColumn('dept_uuid');
        });
    }
};
