<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class gejala extends Model
{
    use HasFactory;
    protected $table = 'gejala'; // Nama tabel
    protected $primaryKey = 'kode_gejala'; // Primary key adalah kode_penyakit
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string
    protected $fillable = ['No', 'kode_gejala','nama_gejala'];

    public function aturanPenyakit()
    {
        return $this->hasMany(AturanPenyakit::class, 'kode_gejala', 'kode_gejala');
    }
}
