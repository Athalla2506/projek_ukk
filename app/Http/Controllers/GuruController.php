<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard', [
            'totalSijaA' => Siswa::where('kelas', 'SIJA A')->count(),
            'totalSijaB' => Siswa::where('kelas', 'SIJA B')->count(),
            'totalGuru' => Guru::count(),
            'siswaA' => Siswa::where('kelas', 'SIJA A')->get(),
            'siswaB' => Siswa::where('kelas', 'SIJA B')->get(),
            'gurus' => Guru::all()
        ]);
    }
}