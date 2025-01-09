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
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->unsignedBigInteger('No'); // kolom ID auto-increment
            $table->string('kode_rekomendasi'); // kolom untuk nama gejala
            $table->text('rekomendasi'); // kolom untuk deskripsi gejala
            $table->timestamps(); // kolom created_at dan updated_at
            $table->primary('kode_rekomendasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};
