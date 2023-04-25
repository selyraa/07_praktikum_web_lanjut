<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;

class MataKuliah extends Model
{
    use HasFactory;
    protected $table = 'matakuliah';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_matkul',
        'sks',
        'jam',
        'semester',
    ];

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class);
    }
}
