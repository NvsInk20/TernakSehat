<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class AkunPengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun_pengguna';
    protected $primaryKey = 'kode_auth';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'No',
        'nama',
        'kode_auth',
        'kode_admin',
        'kode_ahliPakar',
        'kode_user',
        'email',
        'password',
        'role',
        'spesialis',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Boot method untuk event model.
     */
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        // Jika password belum di-hash, lakukan hashing
        if (!empty($model->password)) {
            $model->password = \Hash::make($model->password);
        }

        // Generate kode_auth otomatis jika kosong
        if (empty($model->{$model->getKeyName()})) {
            $model->{$model->getKeyName()} = 'AUT-' . strtoupper(Str::random(5));
        }
    });

    static::updating(function ($model) {
        // Pastikan password di-hash jika diperbarui
        if (!empty($model->password) && $model->isDirty('password')) {
            $model->password = \Hash::make($model->password);
        }
    });

    // Hapus relasi terkait saat akun_pengguna dihapus
    static::deleting(function ($akunPengguna) {
        if ($akunPengguna->kode_ahliPakar) {
            AhliPakar::where('kode_ahliPakar', $akunPengguna->kode_ahliPakar)->delete();
        }

        if ($akunPengguna->kode_user) {
            Pengguna::where('kode_user', $akunPengguna->kode_user)->delete();
        }

        if ($akunPengguna->kode_admin) {
            Admin::where('kode_admin', $akunPengguna->kode_admin)->delete();
        }
    });
}


    /**
     * Relasi ke model Pengguna.
     */
    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'kode_user', 'kode_user');
    }

    /**
     * Relasi ke model AhliPakar.
     */
    public function ahliPakar()
    {
        return $this->belongsTo(AhliPakar::class, 'kode_ahliPakar', 'kode_ahliPakar');
    }

    /**
     * Relasi ke model Admin.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'kode_admin', 'kode_admin');
    }
}
