<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use Illuminate\Http\Request;

class IndustriController extends Controller
{
    public function index()
    {
        return Industri::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:industri,email',
            'guru_pembimbing' => 'required|exists:gurus,id',
        ]);

        $industri = Industri::create($request->all());

        return response()->json([
            'message' => 'Data industri berhasil disimpan',
            'industri' => $industri
        ], 201);
    }

    public function show(string $id)
    {
        $industri = Industri::with('guru')->find($id);

        if (!$industri) {
            return response()->json(['message' => 'Industri tidak ditemukan'], 404);
        }

        return response()->json([
            'industri' => $industri,
            'guru_pembimbing' => $industri->guru?->nama,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $industri = Industri::find($id);

        if (!$industri) {
            return response()->json(['message' => 'Industri tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:industri,email,' . $id,
            'guru_pembimbing' => 'required|exists:gurus,id',
        ]);

        $industri->update($request->all());
        $industri->load('guru');

        return response()->json([
            'message' => 'Data industri berhasil diperbarui',
            'industri' => $industri,
            'guru_pembimbing' => $industri->guru?->nama,
        ]);
    }

    public function destroy(string $id)
    {
        $industri = Industri::find($id);

        if (!$industri) {
            return response()->json(['message' => 'Industri tidak ditemukan'], 404);
        }

        $industri->delete();

        return response()->json(['message' => 'Data industri berhasil dihapus']);
    }
}
