<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use Illuminate\Http\Request;

class IndustriController extends Controller
{
    public function index()
    {
        $industri = Industri::orderBy('nama')->get();
        return view('industri', compact('industri'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:50',
            'alamat' => 'required|max:1000',
            'kontak' => 'nullable|max:15',
            'email' => 'nullable|email|max:30',
            'deskripsi' => 'nullable'
        ]);

        Industri::create($validated);

        return redirect()->route('industri.index')
            ->with('success', 'Data industri berhasil ditambahkan');
    }

    public function destroy($id)
    {
        try {
            $industri = Industri::findOrFail($id);
            $industri->delete();
            
            return redirect()
                ->route('industri.index')
                ->with('success', 'Data industri berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('industri.index')
                ->with('error', 'Gagal menghapus data industri');
        }
    }
}