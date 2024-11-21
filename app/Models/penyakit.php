<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class penyakit extends Model
{
    use HasFactory;
    protected $table = 'penyakit'; // Nama tabel
    protected $primaryKey = 'kode_penyakit'; // Primary key adalah kode_penyakit
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string
    protected $fillable = ['No', 'kode_penyakit','nama_penyakit'];

    public function aturanPenyakit()
    {
        return $this->hasMany(AturanPenyakit::class, 'kode_penyakit', 'kode_penyakit');
    }
}
