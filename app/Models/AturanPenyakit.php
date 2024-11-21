<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AturanPenyakit extends Model
{
    use HasFactory;
    protected $table = 'aturan_penyakit'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key adalah kode_penyakit
    protected $fillable = ['kode_relasi','kode_penyakit','kode_gejala','kode_solusi','jenis_gejala'];

    public function penyakit()
{
    return $this->belongsTo(penyakit::class, 'kode_penyakit', 'kode_penyakit');
}

public function gejala()
{
    return $this->belongsTo(gejala::class, 'kode_gejala', 'kode_gejala');
}

public function solusi()
{
    return $this->belongsTo(solusi::class, 'kode_solusi', 'kode_solusi');
}

}
