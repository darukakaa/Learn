<?php

namespace App\Http\Controllers;

use App\Models\AnswerV2;
use App\Models\QuestionV2;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerV2Controller extends Controller
{
    // Menampilkan pertanyaan berdasarkan kuis
    public function show($quizId)
    {
        // Fetch the questions for the quiz (assuming you have a `quiz_id` in your questions table)
        $questions = QuestionV2::where('quiz_id', $quizId)->get();

        return view('questions.show', compact('questions'));
    }




    // Menyimpan jawaban user ke dalam tabel answers_v2 dan menghitung skor
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|in:A,B,C,D,E', // Validasi jawaban yang dipilih
        ]);

        $userId = auth()->user()->id;
        $quizId = $request->kuis_id;

        // Simpan jawaban yang dipilih ke tabel answers_v2
        foreach ($request->answers as $questionId => $answer) {
            AnswerV2::create([
                'user_id' => $userId,
                'question_id' => $questionId,
                'selected_answer' => $answer,
            ]);
        }

        // Hitung jumlah jawaban yang benar
        $correctCount = 0;
        $totalQuestions = count($request->answers);

        foreach ($request->answers as $questionId => $answer) {
            $question = QuestionV2::find($questionId);
            if ($question && $question->correct_answer === $answer) {
                $correctCount++;
            }
        }

        // Hitung skor dalam bentuk persentase
        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 2) : 0;

        // Simpan skor ke tabel result
        Result::create([
            'user_id' => $userId,
            'kuis_id' => $quizId,
            'score' => $score,
        ]);

        return redirect()->route('kuisv2.index')->with('success', 'Jawaban berhasil disubmit, Skor Anda: ' . $score);
    }


    // Menilai jawaban yang sudah disubmit
    public function score(Request $request)
    {
        $request->validate([
            'kuis_id' => 'required|exists:kuisv2,id',
            'answers' => 'required|array',
        ]);

        $kuisId = $request->input('kuis_id');
        $userAnswers = $request->input('answers');

        $correctCount = 0;
        $totalQuestions = count($userAnswers);

        // Periksa jawaban yang benar
        foreach ($userAnswers as $questionId => $answer) {
            $question = QuestionV2::find($questionId);
            if ($question && $question->correct_answer === $answer) {
                $correctCount++;
            }
        }

        // Hitung skor
        $score = round(($correctCount / $totalQuestions) * 100, 2);

        // Simpan skor ke tabel results
        $result = Result::create([
            'user_id' => auth()->id(),
            'kuis_id' => $kuisId,
            'score' => $score,
        ]);

        // Redirect ke halaman skor dan tampilkan hasilnya
        return view('answers_v2.score', compact('score', 'correctCount', 'totalQuestions'));
    }
}
