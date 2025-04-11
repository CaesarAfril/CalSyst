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
            $table->string('capacity')->nullable()->change();
            $table->string('range')->nullable()->change();
            $table->string('resolution')->nullable()->change();
            $table->string('correction')->nullable()->change();
            $table->string('uncertainty')->nullable()->change();
            $table->string('standard')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('capacity')->nullable(false)->change();
            $table->string('range')->nullable(false)->change();
            $table->string('resolution')->nullable(false)->change();
            $table->string('correction')->nullable(false)->change();
            $table->string('uncertainty')->nullable(false)->change();
            $table->string('standard')->nullable(false)->change();
        });
    }
};
