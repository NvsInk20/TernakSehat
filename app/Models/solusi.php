<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class solusi extends Model
{
    use HasFactory;
    protected $table = 'solusi'; // Nama tabel
    protected $primaryKey = 'kode_solusi'; // Primary key adalah kode_solusi
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Tipe primary key adalah string
    protected $fillable = ['No', 'kode_solusi','solusi'];

    public function aturanPenyakit()
    {
        return $this->hasMany(AturanPenyakit::class, 'kode_solusi', 'kode_solusi');
    }
}
