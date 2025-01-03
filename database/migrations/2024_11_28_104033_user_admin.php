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
        Schema::create('user_admin', function (Blueprint $table) {
            $table->unsignedBigInteger('No');
            $table->string('kode_admin'); 
            $table->string('nama'); // kolom untuk deskripsi gejala
            $table->string('username')->unique(); // kolom untuk deskripsi gejala
            $table->string('password'); // kolom untuk deskripsi gejala
            $table->string('nomor_telp', 12)->nullable(); // kolom untuk deskripsi gejala
            $table->enum('role', ['admin', 'ahli pakar', 'user'])->default('admin');
            $table->primary('kode_admin');
            $table->timestamps(); // kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_admin');
    }
};
