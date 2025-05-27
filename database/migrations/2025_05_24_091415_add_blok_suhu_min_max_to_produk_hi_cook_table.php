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
        Schema::table('produk_hi_cook', function (Blueprint $table) {
            $table->float('blok1_min')->nullable()->after('max');
            $table->float('blok1_max')->nullable()->after('blok1_min');
            $table->float('blok2_min')->nullable()->after('blok1_max');
            $table->float('blok2_max')->nullable()->after('blok2_min');
            $table->float('blok3_min')->nullable()->after('blok2_max');
            $table->float('blok3_max')->nullable()->after('blok3_min');
            $table->float('blok4_min')->nullable()->after('blok3_max');
            $table->float('blok4_max')->nullable()->after('blok4_min');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_hi_cook', function (Blueprint $table) {
            //
        });
    }
};