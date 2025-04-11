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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('plant_uuid');
            $table->uuid('dept_uuid');
            $table->string('location');
            $table->uuid('category');
            $table->string('merk');
            $table->string('type');
            $table->string('series_number');
            $table->string('capacity');
            $table->string('range');
            $table->string('resolution');
            $table->string('correction');
            $table->string('uncertainty');
            $table->decimal('standard', 8, 3);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plant_uuid')->references('uuid')->on('plant')->onDelete('cascade');
            $table->foreign('dept_uuid')->references('uuid')->on('department')->onDelete('cascade');
            $table->foreign('category')->references('uuid')->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
