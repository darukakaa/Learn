<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefleksiUser;

class RefleksiUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'apa_yang_dipelahari' => 'required|string',
            'kesulitan' => 'required|string',
            'kontribusi' => 'required|string',
            'saran' => 'required|string',
        ]);

        RefleksiUser::create([
            'user_id' => auth()->id(),
            'learning_id' => $request->learning_id,
            'apa_yang_dipelahari' => $request->apa_yang_dipelahari,
            'kesulitan' => $request->kesulitan,
            'kontribusi' => $request->kontribusi,
            'saran' => $request->saran,
        ]);

        return redirect()->back()->with('success', 'Refleksi berhasil ditambahkan!');
    }
}
