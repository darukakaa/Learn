<?php

namespace App\Http\Controllers;

use App\Models\Kuisv2;
use Illuminate\Http\Request;


class KuisV2Controller extends Controller
{
    public function show($id)
    {
        $kuis = Kuisv2::findOrFail($id); // Find the quiz by ID

        // Pass the quiz data to the view
        return view('kuisv2.show', compact('kuis'));
    }
    public function start($id)
    {
        $kuis = Kuisv2::findOrFail($id);

        // Handle logic for starting the quiz, such as showing questions
        return view('kuisv2.start', compact('kuis'));
    }

    public function index()
    {
        // Fetch all Kuisv2 entries if you want to display them
        $kuisv2 = Kuisv2::all();

        // Return a view and pass the data if necessary
        return view('kuisv2.index', compact('kuisv2'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_kuis' => 'required|string|max:255',
            'tanggal_kuis' => 'required|date',
        ]);

        Kuisv2::create([
            'nama_kuis' => $request->nama_kuis,
            'tanggal_kuis' => $request->tanggal_kuis,
        ]);

        return redirect()->back()->with('success', 'Kuisv2 berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'nama_kuis' => 'required|string|max:255',
            'tanggal_kuis' => 'required|date',
        ]);

        // Find the KuisV2 entry by ID
        $kuis = KuisV2::findOrFail($id);

        // Update the KuisV2 entry
        $kuis->update([
            'nama_kuis' => $request->input('nama_kuis'),
            'tanggal_kuis' => $request->input('tanggal_kuis'),
        ]);

        // Redirect back with success message
        return redirect()->route('kuisv2.index')->with('success', 'Kuis berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Find the quiz by its ID
        $kuis = KuisV2::findOrFail($id);

        // Delete the quiz
        $kuis->delete();

        // Redirect back with a success message
        return redirect()->route('kuisv2.index')->with('success', 'Kuis berhasil dihapus.');
    }
}
