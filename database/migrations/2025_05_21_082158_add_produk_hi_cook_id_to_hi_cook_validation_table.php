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
        Schema::table('hi_cook_validation', function (Blueprint $table) {
            $table->foreignId('produk_hi_cook_id')
                ->after('id')
                ->constrained('produk_hi_cook')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hi_cook_validation', function (Blueprint $table) {
            $table->dropForeign(['produk_hi_cook_id']);
            $table->dropColumn('produk_hi_cook_id');
        });
    }
};