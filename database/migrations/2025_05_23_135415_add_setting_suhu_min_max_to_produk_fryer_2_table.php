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
        Schema::table('produk_fryer_2', function (Blueprint $table) {
            $table->float('setting_min')->nullable()->after('max');
            $table->float('setting_max')->nullable()->after('setting_min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_fryer_2', function (Blueprint $table) {
            //
        });
    }
};