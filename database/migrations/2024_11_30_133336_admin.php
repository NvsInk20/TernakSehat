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
            $table->unsignedBigInteger('No')->nullable(); 
            $table->string('kode_auth')->primary(); 
            $table->string('nama');
            $table->string('kode_ahliPakar')->nullable();
            $table->string('kode_admin')->nullable();
            $table->string('kode_user')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('spesialis')->nullable(); // Menambahkan nullable agar bisa kosong
            $table->enum('role', ['admin', 'ahli pakar', 'user']);
            $table->timestamps();

            $table->foreign('kode_user')
            ->references('kode_user')->on('user_pengguna')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->foreign('kode_admin')
            ->references('kode_admin')->on('user_admin')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('kode_ahliPakar')
            ->references('kode_ahliPakar')->on('user_pakar')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
