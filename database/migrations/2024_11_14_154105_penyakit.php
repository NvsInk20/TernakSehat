<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('penyakit', function (Blueprint $table) {
            $table->unsignedBigInteger('No'); // Kolom ID dengan auto_increment
            $table->string('kode_penyakit'); // Kolom kode_penyakit
            $table->string('nama_penyakit'); // Kolom nama_penyakit
            $table->timestamps(); // Kolom created_at dan updated_at

            $table->primary('kode_penyakit'); // Menetapkan kode_penyakit sebagai primary key
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyakit');
    }
};
