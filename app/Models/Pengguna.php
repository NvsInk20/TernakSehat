<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_pengguna'; // Nama tabel
    protected $primaryKey = 'kode_user'; // Primary key adalah kode_user
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string

    protected $fillable = [
        'No',
        'nama',
        'kode_user',
        'username',
        'password',
        'nomor_telp',
        'role',
    ];

    /**
     * Boot method untuk event model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate kode_user otomatis saat data dibuat
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = 'USR-' . strtoupper(Str::random(5));
            }
        });

        // Hapus data relasi pada AkunPengguna saat pengguna dihapus
        static::deleting(function ($pengguna) {
            AkunPengguna::where('kode_user', $pengguna->kode_user)->delete();
        });
    }

    /**
     * Relasi ke model AkunPengguna
     */
    public function akunPengguna()
    {
        return $this->hasMany(AkunPengguna::class, 'kode_user', 'kode_user');
    }

    // Relasi ke model RiwayatDiagnosa
    public function riwayatDiagnosa()
    {
        return $this->hasMany(RiwayatDiagnosa::class, 'kode_user', 'kode_user');
    }
    /**
     * Properti yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
    ];
}
