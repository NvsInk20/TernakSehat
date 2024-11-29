<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_admin';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'email', 'password', 'nomor_telp', 'role'];

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
