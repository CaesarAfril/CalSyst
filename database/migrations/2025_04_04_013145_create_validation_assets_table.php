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
        Schema::create('validation_assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('plant_uuid');
            $table->uuid('dept_uuid');
            $table->string('location');
            $table->uuid('machine_uuid');
            $table->string('detail');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plant_uuid')->references('uuid')->on('plant')->onDelete('cascade');
            $table->foreign('dept_uuid')->references('uuid')->on('department')->onDelete('cascade');
            $table->foreign('machine_uuid')->references('uuid')->on('machines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validation_assets');
    }
};
