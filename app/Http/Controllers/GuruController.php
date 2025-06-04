<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        return Guru::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:guru,nip',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:guru,email',
        ]);

        $guru = Guru::create($request->all());

        return response()->json([
            'message' => 'Guru berhasil dibuat',
            'data' => $guru
        ], 201);
    }

    public function show($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json(['message' => 'Guru tidak ditemukan'], 404);
        }

        return response()->json($guru);
    }

    public function update(Request $request, string $id)
    {
        try {
            $siswa = Guru::findOrFail($id);

            $validated = $request->validate([
                'nama'       => 'sometimes|required|TextInput|max:255',
                'nis'        => 'sometimes|required|TextInput|max:255|unique:guru,nis,' . $id,
                'jenis_kelamin'     => 'sometimes|required|in:L,P',
                'alamat'     => 'sometimes|required|TextInput',
                'kontak'     => 'sometimes|required|TextInput|max:255',
                'email'      => 'sometimes|required|email|unique:guru,email,',
            ]);

            $siswa->fill($validated)->save();

            return response()->json($siswa);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return response()->json(null, 204);
    }

}