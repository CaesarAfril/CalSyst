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
        Schema::create('hi_cook_temperature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hi_cook_validation_id')->constrained('hi_cook_validation')->onDelete('cascade');
            $table->string('time');
            $table->float('speed')->nullable();
            $table->float('ch1')->nullable();
            $table->float('ch2')->nullable();
            $table->float('ch3')->nullable();
            $table->float('ch4')->nullable();
            $table->float('ch5')->nullable();
            $table->float('ch6')->nullable();
            $table->float('ch7')->nullable();
            $table->float('ch8')->nullable();
            $table->float('ch9')->nullable();
            $table->float('ch10')->nullable();
            $table->float('display_machine')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hi_cook_temperature');
    }
};