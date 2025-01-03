<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\AkunPengguna;
use App\Models\admin;

class AkunPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('user_admin')->insert([
            'No' => 1,
            'nama' => 'Admin Utama',
            'kode_admin' => 'Adm-2024',
            'username' => 'Admin_TernakSehat',
            'password' => Hash::make('Admin2024'), 
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert ke tabel akun_pengguna
        DB::table('akun_pengguna')->insert([
            'No' => 1,
            'nama' => 'Admin Utama',
            'kode_auth' => 'AUT-SP111',
            'kode_admin' => 'Adm-2024',
            'username' => 'Admin_TernakSehat',
            'password' => Hash::make('Admin2024'), 
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
    }
}
