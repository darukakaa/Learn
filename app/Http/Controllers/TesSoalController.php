<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TesSoal;


class TesSoalController extends Controller
{
    public function index()
    {
        $tes = \App\Models\TesSoal::all();
        return view('tes_soal.index', compact('tes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tes' => 'required|string|max:255',
            'tanggal_tes' => 'required|date',
        ]);

        TesSoal::create([
            'nama_tes' => $request->nama_tes,
            'tanggal_tes' => $request->tanggal_tes,
        ]);

        return redirect()->route('tes_soal.index')->with('success', 'Tes berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tes' => 'required|string|max:255',
            'tanggal_tes' => 'required|date',
        ]);

        $tes = TesSoal::findOrFail($id);
        $tes->update([
            'nama_tes' => $request->nama_tes,
            'tanggal_tes' => $request->tanggal_tes,
        ]);

        return redirect()->route('tes_soal.index')->with('success', 'Tes berhasil diupdate.');
    }

    public function destroy($id)
    {
        $tes = TesSoal::findOrFail($id);
        $tes->delete();

        return redirect()->route('tes_soal.index')->with('success', 'Tes berhasil dihapus.');
    }
}
