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
        Schema::create('machine_validation', function (Blueprint $table) {
            $table->id();
            $table->uuid('machine_uuid');
            $table->foreign('machine_uuid')
                ->references('uuid')
                ->on('machines')
                ->onDelete('cascade');
            $table->foreignId('product_validation_id')
                ->constrained('product_validation')
                ->onDelete('cascade');
            $table->string('product_name')->nullable();
            $table->string('ingredient')->nullable();
            $table->string('packaging')->nullable();
            $table->string('machine_name')->nullable();
            $table->string('dimension')->nullable();
            $table->string('target_temperature')->nullable();
            $table->dateTime('start_testing')->nullable();
            $table->dateTime('end_testing')->nullable();
            $table->string('setting_machine_temperature')->nullable();
            $table->time('product_infeed_time', 3)->nullable();
            $table->string('initial_core_temperature')->nullable();
            $table->string('final_core_temperature')->nullable();
            $table->string('batch')->nullable();
            $table->time('cooking_time', 3)->nullable();
            $table->string('machine_name_2')->nullable();
            $table->string('machine_brand_2')->nullable();
            $table->string('machine_type_2')->nullable();
            $table->string('machine_speed_conv_2')->nullable();
            $table->string('machine_capacity_2')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->text('distribution_notes')->nullable();
            $table->text('chart_notes')->nullable();
            $table->text('out_of_range_notes')->nullable();
            $table->text('uniformity_notes')->nullable();
            $table->text('transcription_notes')->nullable();
            $table->text('conclusion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_validation');
    }
};