<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class AhliPakar extends Authenticatable
{
    use HasFactory;
    protected $table = 'user_pakar'; // Nama tabel
    protected $primaryKey = 'kode_ahliPakar'; // Primary key adalah kode_penyakit
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string
    protected $fillable = ['No', 'nama', 'kode_ahliPakar', 'email', 'password', 'nomor_telp', 'role', 'spesialis'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                // Generate kode_ahliPakar otomatis
                $model->{$model->getKeyName()} = 'APK-' . strtoupper(Str::random(5));
            }
        });
    }
    public function akunPengguna()
{
    return $this->hasMany(akunPengguna::class, 'kode_ahliPakar', 'kode_ahliPakar');
}


    protected $hidden = [
        'password',
    ];
}
