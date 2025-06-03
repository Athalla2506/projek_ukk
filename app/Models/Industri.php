<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    protected $table = 'industris';

    protected $fillable = [
        'nama',
        'alamat',
        'kontak',
        'email',
        'deskripsi',
    ];

    public function getRouteKeyName()
    {
        return 'nama';
    }
}
