<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\penyakit;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penyakit')->insert([
            ['No' => 1, 'kode_penyakit' => 'P01', 'nama_penyakit' => 'ANTHRAK', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 2, 'kode_penyakit' => 'P02', 'nama_penyakit' => 'BRUCELLOSIS (Kluron)', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 3, 'kode_penyakit' => 'P03', 'nama_penyakit' => 'PMK (Penyakit Mulut dan Kuku)', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 4, 'kode_penyakit' => 'P04', 'nama_penyakit' => 'Parasit Darah', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 5, 'kode_penyakit' => 'P05', 'nama_penyakit' => 'LSD (Lumpy Skin Disease)', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 6, 'kode_penyakit' => 'P06', 'nama_penyakit' => 'Cacingan', 'created_at' => now(),
            'updated_at' => now(),], 
            ['No' => 7, 'kode_penyakit' => 'P07', 'nama_penyakit' => 'MASTITIS (Radang Ambing)', 'created_at' => now(),
            'updated_at' => now(),], 
        ]);
    }
}
