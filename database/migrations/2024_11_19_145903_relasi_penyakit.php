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
        Schema::create('aturan_penyakit', function (Blueprint $table) {
            $table->id(); // kolom ID auto-increment
            $table->string('kode_relasi'); // kolom untuk nama gejala
            $table->string('kode_penyakit'); // kolom untuk deskripsi gejala
            $table->string('kode_gejala'); // kolom untuk deskripsi gejala
            $table->string('kode_solusi'); // kolom untuk deskripsi gejala
            $table->enum('jenis_gejala',['wajib', 'opsional']); // kolom untuk deskripsi gejala
            $table->timestamps(); // kolom created_at dan updated_at
            
            $table->foreign('kode_penyakit')
            ->references('kode_penyakit')->on('penyakit')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('kode_gejala')
            ->references('kode_gejala')->on('gejala')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('kode_solusi')
            ->references('kode_solusi')->on('solusi')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_penyakit');
    }
};
