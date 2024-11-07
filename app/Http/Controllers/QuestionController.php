<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kuis;
use App\Models\Question;
use App\Models\Option;

class QuestionController extends Controller
{
    public function store(Request $request, $kuisId)
    {
        // Validate the request data
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:5|max:5',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min:0|max:4',
        ]);

        // Find the Kuis by ID
        $kuis = Kuis::findOrFail($kuisId);

        // Create the question
        $question = $kuis->questions()->create([
            'question' => $request->input('question'),
        ]);

        // Create each option and mark the correct one
        foreach ($request->input('options') as $index => $optionText) {
            $question->options()->create([
                'option' => $optionText,
                'is_correct' => $index == $request->input('correct_option'), // True if it’s the correct option
            ]);
        }


        return redirect()->route('kuis.show', $kuisId)->with('success', 'Question added successfully');
    }
    public function submitAnswers(Request $request, $kuis)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'exists:options,id', // Make sure selected options are valid
        ]);

        // Process the answers, check for correct ones, store or calculate results
        foreach ($validated['answers'] as $questionId => $selectedOptionId) {
            $option = Option::find($selectedOptionId);
            $correct = $option->is_correct ? 'Correct' : 'Incorrect';
            // You can store this information in a user_answer table or any other necessary logic
        }

        // Optionally, return a response to show feedback to the user
        return redirect()->route('kuis.show', ['kuis' => $kuis])->with('status', 'Your answers have been submitted.');
    }
}
