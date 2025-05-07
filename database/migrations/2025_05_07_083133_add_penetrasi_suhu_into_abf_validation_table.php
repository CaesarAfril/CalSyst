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
            $table->string('penetrasi_suhu')->nullable();
            $table->json('suhu_awal_penetrasi')->nullable();
            $table->json('suhu_akhir_penetrasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abf_validation', function (Blueprint $table) {
            $table->dropColumn('penetrasi_suhu');
            $table->dropColumn('suhu_awal_penetrasi');
            $table->dropColumn('suhu_akhir_penetrasi');
        });
    }
};