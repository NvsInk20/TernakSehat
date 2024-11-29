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
    protected $fillable = ['No', 'nama', 'kode_user', 'email', 'password', 'nomor_telp', 'role'];

    /**
     * Fungsi boot untuk membuat kode_user secara otomatis
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                // Generate kode_user otomatis
                $model->{$model->getKeyName()} = 'USR-' . strtoupper(Str::random(5));
            }
        });
    }

    public function akunPengguna()
{
    return $this->hasMany(akunPengguna::class, 'kode_user', 'kode_user');
}

    /**
     * Properti yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
    ];
}
