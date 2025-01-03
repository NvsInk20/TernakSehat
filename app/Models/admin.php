<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class admin extends Authenticatable
{
    use HasFactory;
    protected $table = 'user_admin'; // Nama tabel
    protected $primaryKey = 'kode_admin'; // Primary key adalah kode_penyakit
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string
    protected $fillable = ['No', 'nama', 'kode_admin', 'username', 'password', 'nomor_telp', 'role'];

    protected static function boot()
    {
        parent::boot();

        // Hapus data relasi pada AkunPengguna saat Admin dihapus
        static::deleting(function ($admin) {
            AkunPengguna::where('kode_admin', $admin->kode_admin)->delete();
        });
    }

    public function akunPengguna()
{
    return $this->hasMany(akunPengguna::class, 'kode_admin', 'kode_admin');
}


    protected $hidden = [
        'password',
    ];
}
