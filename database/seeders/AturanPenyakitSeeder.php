<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // Mengimpor DB
use Illuminate\Database\Seeder;

class AturanPenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('aturan_penyakit')->insert([
            ['id' => 1, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G01', 'kode_solusi' => 'S01', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:05:33', 'updated_at' => '2024-12-02 11:05:33'],
            ['id' => 2, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G05', 'kode_solusi' => 'S01', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:05:33', 'updated_at' => '2024-12-02 11:05:33'],
            ['id' => 3, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G14', 'kode_solusi' => 'S01', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:05:33', 'updated_at' => '2024-12-02 11:05:33'],
            ['id' => 4, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G16', 'kode_solusi' => 'S01', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:05:33', 'updated_at' => '2024-12-02 11:05:33'],
            ['id' => 5, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G20', 'kode_solusi' => 'S01', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:05:33', 'updated_at' => '2024-12-02 11:05:33'],
            ['id' => 6, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G13', 'kode_solusi' => 'S01', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:18', 'updated_at' => '2024-12-02 11:06:18'],
            ['id' => 7, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G15', 'kode_solusi' => 'S01', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:18', 'updated_at' => '2024-12-02 11:06:18'],
            ['id' => 8, 'kode_relasi' => 'R01', 'kode_penyakit' => 'P01', 'kode_gejala' => 'G12', 'kode_solusi' => 'S01', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:18', 'updated_at' => '2024-12-02 11:06:18'],
            ['id' => 9, 'kode_relasi' => 'R02', 'kode_penyakit' => 'P02', 'kode_gejala' => 'G11', 'kode_solusi' => 'S02', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:06:18', 'updated_at' => '2024-12-02 11:06:18'],
            ['id' => 10, 'kode_relasi' => 'R02', 'kode_penyakit' => 'P02', 'kode_gejala' => 'G19', 'kode_solusi' => 'S02', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:06:18', 'updated_at' => '2024-12-02 11:06:18'],
            ['id' => 11, 'kode_relasi' => 'R02', 'kode_penyakit' => 'P02', 'kode_gejala' => 'G02', 'kode_solusi' => 'S02', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:18', 'updated_at' => '2024-12-02 11:06:18'],
            ['id' => 12, 'kode_relasi' => 'R02', 'kode_penyakit' => 'P02', 'kode_gejala' => 'G03', 'kode_solusi' => 'S02', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:18', 'updated_at' => '2024-12-02 11:06:18'],
            ['id' => 13, 'kode_relasi' => 'R02', 'kode_penyakit' => 'P02', 'kode_gejala' => 'G04', 'kode_solusi' => 'S02', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:50', 'updated_at' => '2024-12-02 11:06:50'],
            ['id' => 14, 'kode_relasi' => 'R03', 'kode_penyakit' => 'P03', 'kode_gejala' => 'G06', 'kode_solusi' => 'S03', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:06:50', 'updated_at' => '2024-12-02 11:06:50'],
            ['id' => 15, 'kode_relasi' => 'R03', 'kode_penyakit' => 'P03', 'kode_gejala' => 'G07', 'kode_solusi' => 'S03', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:50', 'updated_at' => '2024-12-02 11:06:50'],
            ['id' => 16, 'kode_relasi' => 'R03', 'kode_penyakit' => 'P03', 'kode_gejala' => 'G08', 'kode_solusi' => 'S03', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:50', 'updated_at' => '2024-12-02 11:06:50'],
            ['id' => 17, 'kode_relasi' => 'R03', 'kode_penyakit' => 'P03', 'kode_gejala' => 'G16', 'kode_solusi' => 'S03', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:50', 'updated_at' => '2024-12-02 11:06:50'],
            ['id' => 18, 'kode_relasi' => 'R03', 'kode_penyakit' => 'P03', 'kode_gejala' => 'G01', 'kode_solusi' => 'S03', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:06:50', 'updated_at' => '2024-12-02 11:06:50'],
            ['id' => 19, 'kode_relasi' => 'R03', 'kode_penyakit' => 'P03', 'kode_gejala' => 'G04', 'kode_solusi' => 'S03', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 20, 'kode_relasi' => 'R03', 'kode_penyakit' => 'P03', 'kode_gejala' => 'G02', 'kode_solusi' => 'S03', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 21, 'kode_relasi' => 'R04', 'kode_penyakit' => 'P04', 'kode_gejala' => 'G04', 'kode_solusi' => 'S04', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 22, 'kode_relasi' => 'R04', 'kode_penyakit' => 'P04', 'kode_gejala' => 'G11', 'kode_solusi' => 'S04', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 23, 'kode_relasi' => 'R04', 'kode_penyakit' => 'P04', 'kode_gejala' => 'G09', 'kode_solusi' => 'S04', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 24, 'kode_relasi' => 'R04', 'kode_penyakit' => 'P04', 'kode_gejala' => 'G01', 'kode_solusi' => 'S04', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 25, 'kode_relasi' => 'R04', 'kode_penyakit' => 'P04', 'kode_gejala' => 'G03', 'kode_solusi' => 'S04', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 26, 'kode_relasi' => 'R05', 'kode_penyakit' => 'P05', 'kode_gejala' => 'G10', 'kode_solusi' => 'S05', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 27, 'kode_relasi' => 'R05', 'kode_penyakit' => 'P05', 'kode_gejala' => 'G01', 'kode_solusi' => 'S05', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 28, 'kode_relasi' => 'R05', 'kode_penyakit' => 'P05', 'kode_gejala' => 'G02', 'kode_solusi' => 'S05', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 29, 'kode_relasi' => 'R05', 'kode_penyakit' => 'P05', 'kode_gejala' => 'G04', 'kode_solusi' => 'S05', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 30, 'kode_relasi' => 'R05', 'kode_penyakit' => 'P05', 'kode_gejala' => 'G03', 'kode_solusi' => 'S05', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 31, 'kode_relasi' => 'R06', 'kode_penyakit' => 'P06', 'kode_gejala' => 'G18', 'kode_solusi' => 'S06', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 32, 'kode_relasi' => 'R06', 'kode_penyakit' => 'P06', 'kode_gejala' => 'G04', 'kode_solusi' => 'S06', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 33, 'kode_relasi' => 'R06', 'kode_penyakit' => 'P06', 'kode_gejala' => 'G02', 'kode_solusi' => 'S06', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 34, 'kode_relasi' => 'R06', 'kode_penyakit' => 'P06', 'kode_gejala' => 'G03', 'kode_solusi' => 'S06', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 35, 'kode_relasi' => 'R06', 'kode_penyakit' => 'P06', 'kode_gejala' => 'G17', 'kode_solusi' => 'S06', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 36, 'kode_relasi' => 'R07', 'kode_penyakit' => 'P07', 'kode_gejala' => 'G19', 'kode_solusi' => 'S07', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 37, 'kode_relasi' => 'R07', 'kode_penyakit' => 'P07', 'kode_gejala' => 'G20', 'kode_solusi' => 'S07', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 38, 'kode_relasi' => 'R07', 'kode_penyakit' => 'P07', 'kode_gejala' => 'G21', 'kode_solusi' => 'S07', 'jenis_gejala' => 'wajib', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 39, 'kode_relasi' => 'R07', 'kode_penyakit' => 'P07', 'kode_gejala' => 'G03', 'kode_solusi' => 'S07', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 40, 'kode_relasi' => 'R07', 'kode_penyakit' => 'P07', 'kode_gejala' => 'G04', 'kode_solusi' => 'S07', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47'],
            ['id' => 41, 'kode_relasi' => 'R07', 'kode_penyakit' => 'P07', 'kode_gejala' => 'G01', 'kode_solusi' => 'S07', 'jenis_gejala' => 'opsional', 'created_at' => '2024-12-02 11:08:47', 'updated_at' => '2024-12-02 11:08:47']
        ]);
    }
}
