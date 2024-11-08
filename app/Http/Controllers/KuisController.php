<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\User;
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
        $kuis = Kuis::findOrFail($id);

        // Get the students (role 2) who have answered questions
        $students = User::where('role', 2)
            ->withCount(['answers as correct_answers_count' => function ($query) use ($kuis) {
                $query->whereHas('question', function ($q) use ($kuis) {
                    $q->where('kuis_id', $kuis->id); // Ensure it's related to the specific Kuis
                })
                    ->where('correct', true); // Assuming 'correct' column in answers table
            }])
            ->get();

        // Debug the $students variable
        dd($students);
        $kuis = Kuis::with('questions.options')->findOrFail($id);
        return view('kuis.show', compact('kuis', 'students'));
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
    public function submitAnswers(Request $request, Kuis $kuis)
    {
        // Iterate over the submitted answers
        foreach ($request->answers as $questionId => $answerText) {
            // Find the question
            $question = $kuis->questions()->find($questionId);

            // Create an answer for the question
            $question->answers()->create([
                'user_id' => auth()->id(),
                'answer_text' => $answerText, // or 'answer_id' if you're saving answer IDs
            ]);
        }

        // Redirect to the quiz page or another page
        return redirect()->route('kuis.show', ['kuis' => $kuis->id])->with('status', 'Your answers have been submitted.');
    }
}
