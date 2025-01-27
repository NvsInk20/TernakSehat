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
            ['No' => 1, 'kode_gejala' => 'G01', 'nama_gejala' => 'demam', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 2,'kode_gejala' => 'G02', 'nama_gejala' => 'penurunan berat badan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 3,'kode_gejala' => 'G03', 'nama_gejala' => 'lesu', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 4, 'kode_gejala' => 'G04', 'nama_gejala' => 'penurunan nafsu makan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 5, 'kode_gejala' => 'G05', 'nama_gejala' => 'keluar darah dari lubang telinga, hidung, mulut, kelamin, dan anus', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 6, 'kode_gejala' => 'G06', 'nama_gejala' => 'luka di mulut dan lidah atau sariawan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 7, 'kode_gejala' => 'G07', 'nama_gejala' => 'pincang', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 8, 'kode_gejala' => 'G08', 'nama_gejala' => 'luka di kuku', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 9, 'kode_gejala' => 'G09', 'nama_gejala' => 'kencing darah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 10, 'kode_gejala' => 'G10', 'nama_gejala' => 'benjolan atau bintik di seluruh tubuh', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 11, 'kode_gejala' => 'G11', 'nama_gejala' => 'keguguran usia 5 - 8 bulan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 12, 'kode_gejala' => 'G12', 'nama_gejala' => 'gangguan Pernapasan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 13, 'kode_gejala' => 'G13', 'nama_gejala' => 'gemetar kemudian ternak rebah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 14, 'kode_gejala' => 'G14', 'nama_gejala' => 'gelisah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 15, 'kode_gejala' => 'G15', 'nama_gejala' => 'detak jantung meningkat', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 16, 'kode_gejala' => 'G16', 'nama_gejala' => 'air liur keluar secara berlebihan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 17, 'kode_gejala' => 'G17', 'nama_gejala' => 'perubahan bulu kusam', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 18, 'kode_gejala' => 'G18', 'nama_gejala' => 'mata sayu dan berair', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 19, 'kode_gejala' => 'G19', 'nama_gejala' => 'air susu keluar tidak normal atau penurunan produksi susu', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 20, 'kode_gejala' => 'G20', 'nama_gejala' => 'bila diperah keluar air susu menggumpal', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 21, 'kode_gejala' => 'G21', 'nama_gejala' => 'ambing bengkak dan memerah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 22, 'kode_gejala' => 'G22', 'nama_gejala' => 'cairan janin yang keluar berwarna merah', 'created_at' => now(),
            'updated_at' => now(),],
            ['No' => 23, 'kode_gejala' => 'G23', 'nama_gejala' => 'keropeng di kulit', 'created_at' => now(),
            'updated_at' => now(),],  
            ['No' => 24, 'kode_gejala' => 'G24', 'nama_gejala' => 'diare', 'created_at' => now(),
            'updated_at' => now(),], 
        ]);
    }
}
