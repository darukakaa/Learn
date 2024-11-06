<?php

namespace App\Http\Controllers;

use App\Models\Learning;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    // Fetch and display the learning index page
    public function index()
    {
        // Retrieve all learning items from the database
        $learnings = Learning::orderBy('created_at', 'desc')->get();

        // Return the view with the list of learnings
        return view('learning.index', compact('learnings'));
    }



    // Store a new learning item
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Create new learning (you would replace this with your actual model)
        Learning::create([
            'name' => $request->nama,
        ]);

        return redirect()->route('learning.index')->with('success', 'Learning added successfully.');
    }
    public function destroy($id)
    {
        $learning = Learning::findOrFail($id);
        $learning->delete();

        return redirect()->route('learning.index')->with('success', 'Learning deleted successfully.');
    }
    public function show($id)
    {
        $learning = Learning::findOrFail($id);
        return view('learning.show', compact('learning'));
    }
}
