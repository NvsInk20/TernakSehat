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
        Schema::create('riwayat_diagnosa', function (Blueprint $table) {
            $table->unsignedBigInteger('No'); 
            $table->string('kode_riwayat')->primary(); 
            $table->string('kode_user')->nullable();
            $table->string('nama');
            $table->string('kode_sapi')->nullable();
            $table->string('penyakit_utama')->nullable();
            $table->text('gejala')->nullable();
            $table->text('solusi')->nullable();
            $table->string('penyakit_alternatif_1')->nullable();
            $table->string('penyakit_alternatif_2')->nullable();
            $table->timestamps();

            $table->foreign('kode_user')
            ->references('kode_user')->on('user_pengguna')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_diagnosa');
    }
};
