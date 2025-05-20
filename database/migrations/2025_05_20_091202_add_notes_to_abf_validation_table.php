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
            $table->text('notes_sebaran')->nullable();
            $table->text('notes_grafik')->nullable();
            $table->text('notes_durasi_spike')->nullable();
            $table->text('notes_spike')->nullable();
            $table->text('notes_tabel_penetrasi')->nullable();
            $table->text('notes_grafik_penetrasi')->nullable();
            $table->text('notes_stagnansi')->nullable();
            $table->text('notes_ketercapaian')->nullable();
            $table->text('kesimpulan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abf_validation', function (Blueprint $table) {
            $table->dropColumn('notes_sebaran')->nullable(false)->change();
            $table->dropColumn('notes_grafik')->nullable(false)->change();
            $table->dropColumn('notes_durasi_spike')->nullable(false)->change();
            $table->dropColumn('notes_spike')->nullable(false)->change();
            $table->dropColumn('notes_tabel_penetrasi')->nullable(false)->change();
            $table->dropColumn('notes_grafik_penetrasi')->nullable(false)->change();
            $table->dropColumn('notes_stagnansi')->nullable(false)->change();
            $table->dropColumn('notes_ketercapaian')->nullable(false)->change();
            $table->dropColumn('kesimpulan')->nullable(false)->change();
        });
    }
};