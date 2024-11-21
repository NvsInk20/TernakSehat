<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // Mengimpor DB
use Illuminate\Database\Seeder;

class GejalaSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void 
    { 
        DB::table('gejala')->insert([ 
            ['No' => 1, 'kode_gejala' => 'G01', 'nama_gejala' => 'Demam', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 2,'kode_gejala' => 'G02', 'nama_gejala' => 'Penurunan berat badan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 3,'kode_gejala' => 'G03', 'nama_gejala' => 'Lesu', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 4, 'kode_gejala' => 'G04', 'nama_gejala' => 'Penurunan nafsu makan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 5, 'kode_gejala' => 'G05', 'nama_gejala' => 'Keluar darah dari lubang telinga, hidung, mulut, kelamin, dan anus', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 6, 'kode_gejala' => 'G06', 'nama_gejala' => 'Luka di mulut dan lidah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 7, 'kode_gejala' => 'G07', 'nama_gejala' => 'Pincang', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 8, 'kode_gejala' => 'G08', 'nama_gejala' => 'Luka di kuku', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 9, 'kode_gejala' => 'G09', 'nama_gejala' => 'Kencing darah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 10, 'kode_gejala' => 'G10', 'nama_gejala' => 'Benjolan atau bintik di seluruh tubuh', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 11, 'kode_gejala' => 'G11', 'nama_gejala' => 'Mengalami keguguran/abortus di atas umur 4 bulan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 12, 'kode_gejala' => 'G12', 'nama_gejala' => 'Gangguan Pernapasan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 13, 'kode_gejala' => 'G13', 'nama_gejala' => 'Gemetar kemudian ternak rebah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 14, 'kode_gejala' => 'G14', 'nama_gejala' => 'Gelisah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 15, 'kode_gejala' => 'G15', 'nama_gejala' => 'Jantung terlihat berpacu dengan cepat', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 16, 'kode_gejala' => 'G16', 'nama_gejala' => 'Air liur keluar secara berlebihan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 17, 'kode_gejala' => 'G17', 'nama_gejala' => 'Bulu kusam', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 18, 'kode_gejala' => 'G18', 'nama_gejala' => 'Mata sayu dan berair', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 19, 'kode_gejala' => 'G19', 'nama_gejala' => 'Air susu keluar tidak normal', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 20, 'kode_gejala' => 'G20', 'nama_gejala' => 'Bila diperah keluar air susu menggumpal', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 21, 'kode_gejala' => 'G21', 'nama_gejala' => 'Ambing bengkak dan memerah', 'created_at' => now(),
            'updated_at' => now(),], 
        ]);
    }
}
