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
        Schema::create('gejala', function (Blueprint $table) {
            $table->unsignedBigInteger('No'); // kolom ID auto-increment
            $table->string('kode_gejala'); // kolom untuk nama gejala
            $table->string('nama_gejala'); // kolom untuk deskripsi gejala
            $table->timestamps(); // kolom created_at dan updated_at

            $table->primary('kode_gejala');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};
