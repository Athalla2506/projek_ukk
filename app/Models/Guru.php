<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'gurus';

    protected $fillable = [
        'nama',
        'nip',
        'jenis_kelamin',
        'alamat',
        'kontak',
        'email',
    ];

    protected $casts = [
        'jenis_kelamin' => 'string',
    ];

    public function getJenisKelaminAttribute($value)
    {
        return $value === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
