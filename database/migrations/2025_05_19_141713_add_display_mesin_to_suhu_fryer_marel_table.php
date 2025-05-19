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
        Schema::table('suhu_fryer_marel', function (Blueprint $table) {
            $table->float('display_mesin')->after('ch10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suhu_fryer_marel', function (Blueprint $table) {
            $table->dropColumn('display_mesin');
        });
    }
};