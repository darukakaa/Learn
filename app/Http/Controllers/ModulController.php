<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modul;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    public function index()
    {
        $moduls = Modul::all();
        return view('modul.index', compact('moduls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'file_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        $filePath = $request->file('file_pdf')->store('moduls', 'public');

        Modul::create([
            'nama_modul' => $request->input('nama_modul'),
            'file_pdf' => $filePath,
        ]);

        return redirect()->route('modul.index')->with('success', 'Modul added successfully!');
    }

    public function update(Request $request, Modul $modul)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $modul->nama_modul = $request->input('nama_modul');

        if ($request->hasFile('file_pdf')) {
            if ($modul->file_pdf) {
                Storage::disk('public')->delete($modul->file_pdf);
            }

            $filePath = $request->file('file_pdf')->store('moduls', 'public');
            $modul->file_pdf = $filePath;
        }

        $modul->save();

        return redirect()->route('modul.index')->with('success', 'Modul updated successfully!');
    }

    public function destroy(Modul $modul)
    {
        if ($modul->file_pdf) {
            Storage::disk('public')->delete($modul->file_pdf);
        }

        $modul->delete();

        return redirect()->route('modul.index')->with('success', 'Modul deleted successfully!');
    }
}



