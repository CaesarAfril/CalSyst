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
        Schema::table('fryer_marel_validation', function (Blueprint $table) {
            $table->text('notes_sebaran')->nullable();
            $table->text('notes_grafik')->nullable();
            $table->text('notes_luar_range')->nullable();
            $table->text('notes_keseragaman')->nullable();
            $table->text('notes_rekaman')->nullable();
            $table->text('kesimpulan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fryer_marel_validation', function (Blueprint $table) {
            $table->dropColumn('notes_sebaran')->nullable(false)->change();
            $table->dropColumn('notes_grafik')->nullable(false)->change();
            $table->dropColumn('notes_luar_range')->nullable(false)->change();
            $table->dropColumn('notes_keseragaman')->nullable(false)->change();
            $table->dropColumn('notes_rekaman')->nullable(false)->change();
            $table->dropColumn('kesimpulan')->nullable(false)->change();
        });
    }
};