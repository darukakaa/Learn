<?php

namespace App\Http\Controllers;

use App\Models\Kuisv2;
use App\Models\Result;
use App\Models\AnswerV2;
use App\Models\QuestionV2;
use Illuminate\Http\Request;


class KuisV2Controller extends Controller
{

    public function start($id)
    {
        $kuis = Kuisv2::findOrFail($id);

        // Handle logic for starting the quiz, such as showing questions
        return view('kuisv2.start', compact('kuis'));
    }

    public function index()
    {
        $kuisv2 = Kuisv2::orderBy('created_at', 'desc')->get();

        $submittedKuisIds = AnswerV2::where('user_id', auth()->id())
            ->join('questionsv2', 'answers_v2.question_id', '=', 'questionsv2.id')
            ->pluck('questionsv2.kuis_id')
            ->unique();

        return view('kuisv2.index', compact('kuisv2', 'submittedKuisIds'));
    }

    public function show($id)
    {
        $kuis = Kuisv2::findOrFail($id); // Find the quiz by ID

        // Pass the quiz data to the view
        return view('kuisv2.show', compact('kuis'));
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
    public function showScore($id)
    {
        // Ambil data kuis beserta pertanyaan dan jawaban user yang login
        $kuis = Kuisv2::with(['questionsV2.userAnswer'])->findOrFail($id);

        $result = Result::where('kuis_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$result) {
            return redirect()->route('kuisv2.index')->with('error', 'Data score tidak ditemukan.');
        }

        return view('nilai.index', [
            'score' => $result->score,
            'kuis' => $kuis, // <-- penting untuk ditampilkan di view
        ]);
    }
}
