<?php

namespace App\Http\Controllers;

use App\Models\Kuisv2;
use App\Models\QuestionV2;
use Illuminate\Http\Request;

class QuestionV2Controller extends Controller
{
    public function show($id)
    {
        // Fetch the quiz
        $kuis = Kuisv2::findOrFail($id);

        // Fetch the associated questions for the quiz
        $questions = $kuis->questions;

        // Return the view with both quiz and questions
        return view('kuisv2.show', compact('kuis', 'questions'));
    }

    public function store(Request $request, $kuis_id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'option_e' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        // Save the question and options
        QuestionV2::create([
            'kuis_id' => $kuis_id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('questions.show', $kuis_id)->with('success', 'Soal berhasil ditambahkan!');
    }
}
