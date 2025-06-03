<?php

namespace App\Http\Controllers;

use App\Models\Pkl;
use App\Models\Siswa;
use App\Models\Industri;
use Illuminate\Http\Request;

class SiswaPklController extends Controller
{
    public function daftar()
    {
        $user = auth()->user();
        $siswa = Siswa::where('email', $user->email)->firstOrFail();
        $pkl = Pkl::where('siswa_id', $siswa->id)->first();
        $industris = Industri::all();

        return view('siswa.daftar-pkl', compact('pkl', 'industris', 'siswa'));
    }

    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'industri_id' => 'required|exists:industris,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ], [
            'industri_id.required' => 'Tempat PKL wajib dipilih',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
        ]);

        $user = auth()->user();
        $siswa = Siswa::where('email', $user->email)->firstOrFail(); 
        // Cek apakah sudah pernah daftar
        if(Pkl::where('siswa_id', $siswa->id)->exists()) {
            return back()->with('error', 'Anda sudah pernah mendaftar PKL');
        }

        // Ganti bagian ini
        // $guru = \App\Models\Guru::first();
        $guru = \App\Models\Guru::inRandomOrder()->first();

        // Simpan data PKL dengan guru_id acak
        Pkl::create([
            'siswa_id' => $siswa->id,
            'industri_id' => $validated['industri_id'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'guru_id' => $guru ? $guru->id : 1  // Menggunakan guru acak atau ID 1 jika tidak ada guru
        ]);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Pendaftaran PKL berhasil. Silakan tunggu persetujuan.');
    }
}