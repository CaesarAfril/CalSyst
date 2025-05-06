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
        Schema::create('abf_validation', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_pengujian');
            $table->dateTime('end_pengujian');
            $table->integer('pengujian');
            $table->string('nama_produk')->nullable();
            $table->string('ingredient')->nullable();
            $table->string('kemasan')->nullable();
            $table->string('nama_mesin')->nullable();
            $table->string('dimensi')->nullable();
            $table->string('kapasitas')->nullable();
            $table->string('susunan')->nullable();
            $table->string('isi_rak')->nullable();
            $table->string('penumpukan')->nullable();
            $table->string('target_suhu')->nullable();
            $table->string('set_thermostat')->nullable();
            $table->string('nama_mesin_2')->nullable();
            $table->string('merek_mesin_2')->nullable();
            $table->string('tipe_mesin_2')->nullable();
            $table->string('freon_mesin_2')->nullable();
            $table->string('kapasitas_mesin_2')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abf_validation');
    }
};