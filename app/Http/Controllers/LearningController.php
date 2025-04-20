<?php

namespace App\Http\Controllers;

use App\Models\Learning;
use App\Models\LearningStage1;
use App\Models\LearningStage1Result;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    // Fetch and display the learning index page
    public function index()
    {
        $learnings = Learning::orderBy('created_at', 'desc')->get();
        return view('learning.index', compact('learnings'));
    }

    // Store a new learning item
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

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
        $learning = Learning::findOrFail($id);

        // Retrieve the learning stage data (you can adjust as needed)
        $learningStage1 = LearningStage1::with('learningStage1Results.user')
            ->where('learning_id', $id)
            ->first();

        // Check if the user has already added a result
        $existingResult = $learningStage1 ? LearningStage1Result::where('learning_stage1_id', $learningStage1->id)
            ->where('user_id', auth()->id())
            ->exists() : false;

        return view('learning.show', compact('learning', 'learningStage1', 'existingResult'));
    }

    // Store the stage 1 data for learning
    public function storeStage1(Request $request, $id)
    {
        $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'problem' => 'required|string|max:255',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/learning_stage1', $fileName, 'public');
        }

        LearningStage1::create([
            'learning_id' => $request->input('learning_id'),
            'problem' => $request->input('problem'),
            'file' => $filePath,
        ]);

        return redirect()->route('learning.show', ['learning' => $id])->with('success', 'Data Tahap 1 berhasil ditambahkan!');
    }

    // Store the result data for learning stage 1
    public function storeStage1Result(Request $request, $learningStage1Id)
    {
        $request->validate([
            'result' => 'required|string|max:255',
        ]);

        $learningStage1 = LearningStage1::find($learningStage1Id);

        if (!$learningStage1) {
            return redirect()->route('learning.index')
                ->with('error', 'Learning Stage 1 tidak ditemukan.');
        }

        $existingResult = LearningStage1Result::where('learning_stage1_id', $learningStage1Id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingResult) {
            return redirect()->route('learning.show', ['learning' => $learningStage1->learning_id])
                ->with('error', 'Anda hanya dapat menambahkan satu hasil identifikasi masalah.');
        }

        LearningStage1Result::create([
            'learning_stage1_id' => $learningStage1Id,
            'user_id' => auth()->user()->id,
            'result' => $request->result,
        ]);

        return redirect()->route('learning.show', ['learning' => $learningStage1->learning_id])
            ->with('success', 'Hasil Identifikasi Masalah berhasil ditambahkan!');
    }

    // Show Stage 2
    public function showStage2($learningId)
    {
        $learning = Learning::findOrFail($learningId);

        // Ambil semua kelompok yang terkait dengan learning_id dan urutkan berdasarkan created_at
        $kelompok = Kelompok::where('learning_id', $learningId)
            ->orderBy('created_at', 'desc')  // Paling baru di atas
            ->get();

        return view('learning.stage2', compact('learning', 'kelompok'));
    }

    public function showInStage2($learningId, $id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $learning = Learning::findOrFail($learningId);

        return view('kelompok.show', compact('kelompok', 'learning'));
    }




    // Store a new group (Kelompok)
    public function storeKelompok(Request $request, $learningId)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'jumlah_kelompok' => 'required|integer|min:1',
        ]);

        Kelompok::create([
            'learning_id' => $learningId,
            'nama_kelompok' => $request->nama_kelompok,
            'jumlah_kelompok' => $request->jumlah_kelompok,
        ]);

        return redirect()->route('learning.stage2', $learningId)->with('success', 'Kelompok berhasil ditambahkan!');
    }
}
