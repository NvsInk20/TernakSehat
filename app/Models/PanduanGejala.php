<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PanduanGejala extends Model
{
    use HasFactory;
    protected $table = 'panduan_gejala'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key adalah kode_penyakit
    protected $fillable = ['kode_gejala','foto_dokumen', 'deskripsi_panduan'];

    public function gejalaPanduan()
    {
        return $this->belongsTo(gejala::class, 'kode_gejala', 'kode_gejala');
    }
}
