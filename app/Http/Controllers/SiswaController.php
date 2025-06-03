<?php

namespace App\Http\Controllers;

use App\Models\Pkl;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $siswa = Siswa::where('email', $user->email)->first();
        $pkl = Pkl::with(['industri', 'guru'])
            ->where('siswa_id', $siswa->id)
            ->first();

        $siswaList = Siswa::whereHas('pkl')->with('pkl.industri')->get();

        return view('siswa.dashboard', [
            'pkl' => $pkl,
            'siswaList' => $siswaList
        ]);
    }
}