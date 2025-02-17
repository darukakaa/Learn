<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    public function showForm($learningId, $stageId)
    {
        // Mengambil semua kelompok berdasarkan learningId dan stageId
        $kelompok = Kelompok::where('learning_id', $learningId)
            ->where('stage_id', $stageId)
            ->get();


        // Mengirimkan data ke view
        return view('kelompok.show', compact('kelompok', 'learningId', 'stageId'));
    }

    // Method untuk menghapus kelompok
    public function destroy($id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $kelompok->delete();

        return redirect()->back()->with('success', 'Kelompok berhasil dihapus!');
    }




    public function store(Request $request, $learningId, $stageId)
    {
        // Validasi form
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'jumlah_kelompok' => 'required|integer|min:1|max:5',
        ]);

        // Menyimpan kelompok baru
        Kelompok::create([
            'nama_kelompok' => $request->nama_kelompok,
            'jumlah_kelompok' => $request->jumlah_kelompok,
            'learning_id' => $learningId,
            'stage_id' => $stageId,
        ]);

        // Mengambil kembali data kelompok setelah disimpan
        $kelompok = Kelompok::where('learning_id', $learningId)
            ->where('stage_id', $stageId)
            ->get();

        // Redirect kembali ke halaman yang sama (stage2.blade.php)
        return redirect()->route('learning.stage', ['learningId' => $learningId, 'stageId' => $stageId])
            ->with('success', 'Kelompok berhasil ditambahkan')
            ->with(compact('kelompok', 'learningId', 'stageId')); // Menambahkan $kelompok di sini
    }
}
