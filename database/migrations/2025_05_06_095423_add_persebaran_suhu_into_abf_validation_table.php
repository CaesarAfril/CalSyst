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
        Schema::table('abf_validation', function (Blueprint $table) {
            // $table->string('persebaran_suhu')->nullable();
            $table->json('suhu_awal')->nullable();
            $table->json('suhu_akhir')->nullable();
            $table->time('jam_awal')->nullable();
            $table->time('jam_akhir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abf_validation', function (Blueprint $table) {
            $table->dropColumn('persebaran_suhu');
            $table->dropColumn('suhu_awal');
            $table->dropColumn('suhu_akhir');
            $table->dropColumn('jam_awal');
            $table->dropColumn('jam_akhir');
        });
    }
};