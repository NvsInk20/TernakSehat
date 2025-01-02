<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class AhliPakar extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_pakar'; // Nama tabel
    protected $primaryKey = 'kode_ahliPakar'; // Primary key adalah kode_ahliPakar
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string

    protected $fillable = [
        'No',
        'nama',
        'kode_ahliPakar',
        'email',
        'password',
        'dokumen_pendukung',
        'nomor_telp',
        'role',
        'spesialis',
        'status',
    ];

    /**
     * Boot method untuk event model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate kode_ahliPakar otomatis saat data dibuat
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = 'APK-' . strtoupper(Str::random(5));
            }
        });

        // Hapus data relasi pada AkunPengguna saat AhliPakar dihapus
        static::deleting(function ($ahliPakar) {
            AkunPengguna::where('kode_ahliPakar', $ahliPakar->kode_ahliPakar)->delete();
        });
    }

    /**
     * Relasi ke model AkunPengguna
     */
    public function akunPengguna()
    {
        return $this->hasMany(AkunPengguna::class, 'kode_ahliPakar', 'kode_ahliPakar');
    }

    /**
     * Properti yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
    ];
}
