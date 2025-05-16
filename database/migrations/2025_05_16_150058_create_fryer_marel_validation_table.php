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
        Schema::create('fryer_marel_validation', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk')->nullable();
            $table->string('ingredient')->nullable();
            $table->string('kemasan')->nullable();
            $table->string('nama_mesin')->nullable();
            $table->string('dimensi')->nullable();
            $table->string('target_suhu')->nullable();
            $table->dateTime('start_pengujian')->nullable();
            $table->dateTime('end_pengujian')->nullable();
            $table->string('setting_suhu_mesin')->nullable();
            $table->time('waktu_produk_infeed', 3)->nullable();
            $table->string('suhu_awal_inti')->nullable();
            $table->string('suhu_akhir_inti')->nullable();
            $table->string('batch')->nullable();
            $table->time('waktu_pemasakan', 3)->nullable();
            $table->string('nama_mesin_2')->nullable();
            $table->string('merek_mesin_2')->nullable();
            $table->string('tipe_mesin_2')->nullable();
            $table->string('speed_conv_mesin_2')->nullable();
            $table->string('kapasitas_mesin_2')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('alamat')->nullable();
            $table->string('suhu_fryer_marel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fryer_marel_validation');
    }
};