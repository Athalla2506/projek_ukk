<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pkl extends Model
{
    protected $table = 'pkls';


    protected $fillable = [
        'siswa_id',
        'industri_id',
        'guru_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];




    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status' => 'boolean',
    ];


    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }


    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }


    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function getTanggalMulaiFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_mulai)->format('d-m-Y');
    }
    public function getTanggalSelesaiFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_selesai)->format('d-m-Y');
    }
    public function getStatusAttribute()
    {
        $today = now();
        if ($today < $this->tanggal_mulai) {
            return 'Belum Mulai';
        } elseif ($today > $this->tanggal_selesai) {
            return 'Selesai';
        } else {
            return 'Sedang Berlangsung';
        }
    }
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'Belum Mulai':
                return 'bg-gray-500';
            case 'Sedang Berlangsung':
                return 'bg-yellow-500';
            case 'Selesai':
                return 'bg-green-500';
            default:
                return 'bg-gray-500';
        }
    }
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'Belum Mulai' => 'Belum Mulai',
            'Sedang Berlangsung' => 'Sedang Berlangsung',
            'Selesai' => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }
}
