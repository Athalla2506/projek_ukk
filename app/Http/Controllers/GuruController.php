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
        return response()->json([
            'totalSijaA' => Siswa::where('kelas', 'SIJA A')->count(),
            'totalSijaB' => Siswa::where('kelas', 'SIJA B')->count(),
            'totalGuru' => Guru::count(),
            'siswaA' => Siswa::where('kelas', 'SIJA A')->get(),
            'siswaB' => Siswa::where('kelas', 'SIJA B')->get(),
            'gurus' => Guru::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:gurus,email',
        ]);

        $guru = Guru::create($validated);

        return response()->json([
            'message' => 'Guru berhasil dibuat',
            'data' => $guru
        ], 201);
    }

    // public function show($id)
    // {
    //     $guru = Guru::find($id);

    //     if (!$guru) {
    //         return response()->json(['message' => 'Guru tidak ditemukan'], 404);
    //     }

    //     return response()->json($guru);
    // }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $guru = Guru::findOrFail($id);

    //         $validated = $request->validate([
    //             'nama' => 'sometimes|required|string|max:255',
    //             'nip' => 'sometimes|required|string|max:255|unique:gurus,nip,' . $id,
    //             'jenis_kelamin' => 'sometimes|required|in:L,P',
    //             'alamat' => 'sometimes|required|string',
    //             'kontak' => 'sometimes|nullable|string|max:20',
    //             'email' => 'sometimes|nullable|email|unique:gurus,email,' . $id,
    //         ]);

    //         $guru->update($validated);

    //         return response()->json($guru);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Server Error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function destroy(Guru $guru)
    // {
    //     $guru->delete();
    //     return response()->json(['message' => 'Guru berhasil dihapus.'], 204);
    // }
}
