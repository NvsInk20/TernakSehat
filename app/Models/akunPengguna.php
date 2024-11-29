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
    protected $fillable = ['No', 'nama', 'kode_auth', 'kode_ahliPakar', 'kode_user', 'email', 'password', 'role', 'spesialis'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                // Generate kode_ahliPakar otomatis
                $model->{$model->getKeyName()} = 'AUT-' . strtoupper(Str::random(5));
            }
        });
    }
    public function user()
{
    return $this->belongsTo(Pengguna::class, 'kode_user', 'kode_user');
}

public function ahliPakar()
{
    return $this->belongsTo(AhliPakar::class, 'kode_ahliPakar', 'kode_ahliPakar');
}

    protected $hidden = [
        'password',
    ];
}
