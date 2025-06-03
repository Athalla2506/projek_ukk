<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Siswa extends Model
{
    protected $table = 'siswas';


    protected $fillable = [
        'nama',
        'nis',
        'jenis_kelamin',
        'kelas',
        'alamat',
        'kontak',
        'email',
        'status_pkl',
    ];


    protected $casts = [
        'status_pkl' => 'boolean',
    ];
   
    public function pkl(): HasOne
    {
        return $this->hasOne(Pkl::class, 'siswa_id');
    }
   
    public function getJenisKelaminAttribute($value)
    {
        return $value === 'L' ? 'Laki-laki' : 'Perempuan';
    }

}
