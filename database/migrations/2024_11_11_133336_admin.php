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
        Schema::create('akun_Pengguna', function (Blueprint $table) {
            $table->string('id', 5)->primary(); 
            $table->string('nama');
            $table->string('email');
            $table->string('password');
            $table->string('spesialis')->nullable(); // Menambahkan nullable agar bisa kosong
            $table->enum('role', ['admin', 'ahli pakar', 'user']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_Pengguna');
    }
};