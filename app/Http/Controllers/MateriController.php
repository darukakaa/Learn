<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    // Display a list of all materi
    public function index()
    {
        // Fetch all materi records from the database
        $materis = Materi::all();

        // Pass the data to the view
        return view('materi.index', compact('materis'));
    }

    // Show the form to create a new materi
    public function create()
    {
        return view('materi.create');
    }

    // Store a newly created materi in storage
    public function store(Request $request)
    {
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'file_ppt' => 'nullable|file|mimes:ppt,pptx',
            'file_pdf' => 'nullable|file|mimes:pdf',
        ]);

        Materi::create($request->all());

        return redirect()->route('materi.index')->with('success', 'Materi created successfully.');
    }

    // Show the form to edit an existing materi
    public function edit(Materi $materi)
    {
        return view('materi.edit', compact('materi'));
    }

    // Update an existing materi in storage
    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'file_ppt' => 'nullable|file|mimes:ppt,pptx',
            'file_pdf' => 'nullable|file|mimes:pdf',
        ]);

        $materi->update($request->all());

        return redirect()->route('materi.index')->with('success', 'Materi updated successfully.');
    }

    // Remove a materi from storage
    public function destroy(Materi $materi)
    {
        $materi->delete();
        return redirect()->route('materi.index')->with('success', 'Materi deleted successfully.');
    }
}
