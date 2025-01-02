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
        Schema::create('user_pakar', function (Blueprint $table) {
            $table->unsignedBigInteger('No'); 
            $table->string('kode_ahliPakar');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('dokumen_pendukung')->nullable(); // Menyimpan path file dokumen PDF
            $table->string('nomor_telp', 12)->nullable();
            $table->string('spesialis')->nullable(); // Menambahkan nullable agar bisa kosong
            $table->enum('role', ['admin', 'ahli pakar', 'user'])->default('ahli pakar');;
            $table->primary('kode_ahliPakar');
            $table->string('status')->default('inactive'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pakar');
    }
};
