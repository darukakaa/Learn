<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluasi;
use App\Models\Kelompok;

class EvaluasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kelompok_id' => 'required|exists:kelompok,id',
            'learning_id' => 'required|exists:learnings,id',
            'deskripsi' => 'required|string',
        ]);

        $evaluasi = Evaluasi::create([
            'kelompok_id' => $request->kelompok_id,
            'learning_id' => $request->learning_id,
            'created_by' => auth()->id(),
            'deskripsi' => $request->deskripsi,
        ]);

        $kelompok = Kelompok::find($request->kelompok_id);

        return redirect()->back()->with('success', 'Anda telah menambahkan evaluasi pada kelompok ' . $kelompok->nama_kelompok);
    }
}
