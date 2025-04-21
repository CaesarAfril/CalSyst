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
        Schema::table('assets', function (Blueprint $table) {
            $table->decimal('correction', 8, 3)->change()->nullable();
            $table->decimal('uncertainty', 8, 3)->change()->nullable();
            $table->decimal('resolution', 8, 3)->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('resolution')->change();
            $table->string('correction')->change();
            $table->string('uncertainty')->change();
        });
    }
};
