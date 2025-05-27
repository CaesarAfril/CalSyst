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
        Schema::create('hi_cook_product', function (Blueprint $table) {
            $table->id();
            $table->uuid('machine_uuid');
            $table->foreign('machine_uuid')
                ->references('uuid')
                ->on('validation_assets')
                ->onDelete('cascade');
            $table->string('product_name');
            $table->float('min')->nullable();
            $table->float('max')->nullable();
            $table->float('blok1_min')->nullable();
            $table->float('blok1_max')->nullable();
            $table->float('blok2_min')->nullable();
            $table->float('blok2_max')->nullable();
            $table->float('blok3_min')->nullable();
            $table->float('blok3_max')->nullable();
            $table->float('blok4_min')->nullable();
            $table->float('blok4_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hi_cook_product');
    }
};