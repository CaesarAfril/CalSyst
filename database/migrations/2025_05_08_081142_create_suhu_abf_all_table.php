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
        Schema::create('suhu_abf_all', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abf_validation_id')->constrained('abf_validation')->onDelete('cascade');
            $table->time('time')->nullable();
            $table->decimal('ch1', 5, 2)->nullable();
            $table->decimal('ch2', 5, 2)->nullable();
            $table->decimal('ch3', 5, 2)->nullable();
            $table->decimal('ch4', 5, 2)->nullable();
            $table->decimal('ch5', 5, 2)->nullable();
            $table->decimal('ch6', 5, 2)->nullable();
            $table->decimal('ch7', 5, 2)->nullable();
            $table->decimal('ch8', 5, 2)->nullable();
            $table->decimal('ch9', 5, 2)->nullable();
            $table->decimal('ch10', 5, 2)->nullable();
            $table->decimal('titik1', 5, 2)->nullable();
            $table->decimal('titik2', 5, 2)->nullable();
            $table->decimal('titik3', 5, 2)->nullable();
            $table->decimal('titik4', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suhu_abf_all');
    }
};