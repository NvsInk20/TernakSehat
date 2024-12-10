<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class RiwayatDiagnosa extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'riwayat_diagnosa';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'kode_riwayat';
    protected $fillable = [
        'No', 
        'kode_riwayat', 
        'kode_user', 
        'nama', 
        'kode_sapi', 
        'penyakit_utama',
        'gejala', 
        'solusi', 
        'penyakit_alternatif_1', 
        'penyakit_alternatif_2'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                // Generate kode_ahliPakar otomatis
                $model->{$model->getKeyName()} = 'RDG-' . strtoupper(Str::random(5));
            }
        });
    }
    public function user()
{
    return $this->belongsTo(Pengguna::class, 'kode_user', 'kode_user');
}

}
