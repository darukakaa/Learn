<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuis;
use App\Models\Question;

class QuestionsController extends Controller
{
    public function store(Request $request, $kuisId)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array',
            'options.*' => 'required|string|max:255',
            'correct_option' => 'required|string|in:A,B,C,D,E',
        ]);

        $kuis = Kuis::findOrFail($kuisId);

        $question = new Question();
        $question->question = $request->input('question');
        $question->kuis_id = $kuis->id;

        // Save the question
        $question->save();

        // Save options
        foreach ($request->input('options') as $index => $option) {
            $question->options()->create([
                'option' => $option,
                'is_correct' => $request->input('correct_option') == chr(65 + $index), // Convert index to A-E
            ]);
        }

        return redirect()->route('kuis.show', $kuis->id)->with('success', 'Question added successfully.');
    }
}

