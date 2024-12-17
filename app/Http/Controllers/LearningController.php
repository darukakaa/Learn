<?php

namespace App\Http\Controllers;

use App\Models\Learning;
use App\Models\LearningStage1;
use App\Models\LearningStage1Result;
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

    // Delete a learning item
    public function destroy($id)
    {
        $learning = Learning::findOrFail($id);
        $learning->delete();

        return redirect()->route('learning.index')->with('success', 'Learning deleted successfully.');
    }

    // Show a single learning item
    public function show($id)
    {
        // Ambil data learning berdasarkan ID
        $learning = Learning::findOrFail($id);

        // Ambil data learning_stage1 berdasarkan learning_id
        $learningStage1 = LearningStage1::where('learning_id', $id)->first();

        // Kirim data ke view
        return view('learning.show', compact('learning', 'learningStage1'));
    }

    // Store the stage 1 data for learning
    public function storeStage1(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'problem' => 'required|string|max:255',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/learning_stage1', $fileName, 'public');
        }

        // Simpan data ke tabel learning_stage1
        $learningStage1 = LearningStage1::create([
            'learning_id' => $request->input('learning_id'),
            'problem' => $request->input('problem'),
            'file' => $filePath,
        ]);

        // Redirect kembali ke halaman detail learning
        return redirect()->route('learning.show', ['learning' => $id])->with('success', 'Data Tahap 1 berhasil ditambahkan!');
    }

    // Store the result data for learning stage 1
    public function storeStage1Result(Request $request, $learningStage1Id)
    {
        // Validasi input
        $request->validate([
            'result' => 'required|string|max:255',
        ]);

        // Pastikan learning_stage1_id ada di tabel learning_stage1
        $learningStage1 = LearningStage1::find($learningStage1Id);

        if (!$learningStage1) {
            return redirect()->route('learning.show', ['learning' => $learningStage1->learning_id])
                ->with('error', 'Learning Stage 1 not found.');
        }

        // Simpan data ke tabel learning_stage1_results
        $learningStage1Result = LearningStage1Result::create([
            'learning_stage1_id' => $learningStage1Id,
            'user_id' => auth()->user()->id, // Menyimpan ID user yang sedang login
            'result' => $request->result, // Hasil identifikasi masalah
        ]);

        // Periksa apakah data berhasil disimpan
        if ($learningStage1Result) {
            return redirect()->route('learning.show', ['learning' => $learningStage1->learning_id])
                ->with('success', 'Hasil Identifikasi Masalah berhasil ditambahkan!');
        } else {
            return redirect()->route('learning.show', ['learning' => $learningStage1->learning_id])
                ->with('error', 'Gagal menambahkan hasil identifikasi masalah.');
        }
    }
}
