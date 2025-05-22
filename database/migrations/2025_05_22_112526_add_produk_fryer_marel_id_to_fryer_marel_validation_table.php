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
            $table->foreignId('produk_fryer_marel_id')
                ->after('id')
                ->constrained('produk_fryer_marel')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fryer_marel_validation', function (Blueprint $table) {
             $table->dropForeign(['produk_fryer_marel_id']);
            $table->dropColumn('produk_fryer_marel_id');
        });
    }
};