<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    public function index()
    {
        $kuis = Kuis::all();
        return view('kuis.index', compact('kuis'));
    }

    public function show($id)
    {
        // Fetch the kuis with its related questions and options
        $kuis = Kuis::with('questions.options')->findOrFail($id);

        // Pass the kuis data to the view
        return view('kuis.show', ['kuis' => $kuis]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_kuis' => 'required|string|max:255',
            'tanggal_ditambahkan' => 'required|date',
        ]);

        Kuis::create($request->all());

        return redirect()->route('kuis.index');
    }

    public function destroy($id)
    {
        Kuis::destroy($id);

        return redirect()->route('kuis.index');
    }
}
