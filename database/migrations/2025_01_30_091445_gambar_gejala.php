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
        Schema::create('panduan_gejala', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('kode_gejala'); // Foreign key ke tabel gejala
            $table->text('foto_dokumen')->nullable(); // kolom untuk deskripsi gejala
            $table->text('deskripsi_panduan')->nullable(); // kolom untuk deskripsi gejala
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraint
            $table->foreign('kode_gejala')->references('kode_gejala')->on('gejala')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panduan_gejala');
    }
};
