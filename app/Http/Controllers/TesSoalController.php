<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TesSoal;
use App\Models\Soal;
use App\Models\Jawaban;


class TesSoalController extends Controller
{
    public function index()
    {
        $tes = TesSoal::all()->map(function ($item) {
            $item->sudah_mengerjakan = Jawaban::where('tes_soal_id', $item->id)
                ->where('user_id', Auth::id())
                ->exists();
            return $item;
        });

        return view('tes_soal.index', compact('tes'));
    }

    public function show($id)
    {
        // Ambil data tes dan soal yang terkait
        $tes = TesSoal::findOrFail($id);
        $soals = Soal::where('tes_soals_id', $id)->get();
        $waktuDalamDetik = 1800;
        return view('tes_soal.show', compact('tes', 'soals', 'waktuDalamDetik'));
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

        return redirect()->route('tes_soal.index')->with('success', 'Tes berhasil ditambahkan.');
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
