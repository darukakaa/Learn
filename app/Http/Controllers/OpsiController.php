<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\Soal;
use Illuminate\Http\Request;

class OpsiController extends Controller
{
    public function store(Request $request, $soal_id)
    {
        $request->validate([
            'opsi' => 'required|in:A,B,C,D,E',
            'teks' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        $soal = Soal::findOrFail($soal_id);

        Opsi::create([
            'soal_id' => $soal->id,
            'opsi' => $request->opsi,
            'teks' => $request->teks,
            'is_correct' => $request->is_correct,
        ]);

        return redirect()->back()->with('success', 'Opsi berhasil ditambahkan');
    }
}
