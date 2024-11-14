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
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'email', 'password', 'role', 'spesialis'];

    // // Fungsi boot untuk membuat ID secara otomatis dengan 5 karakter
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         if (empty($model->{$model->getKeyName()})) {
    //             $model->{$model->getKeyName()} = Str::random(5);
    //         }
    //     });
    // }

    protected $hidden = [
        'password',
    ];
}
