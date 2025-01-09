<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rekomendasi extends Model
{
    use HasFactory;
    protected $table = 'rekomendasi'; // Nama tabel
    protected $primaryKey = 'kode_rekomendasi'; // Primary key adalah kode_solusi
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string
    protected $fillable = ['No', 'kode_rekomendasi','rekomendasi'];

    public function aturanPenyakit()
    {
        return $this->hasMany(AturanPenyakit::class, 'kode_rekomendasi', 'kode_rekomendasi');
    }
}
