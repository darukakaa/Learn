<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\KuisV2;
use App\Models\QuestionV2;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function show($id)
    {
        $kuis = KuisV2::findOrFail($id); // Ambil data kuis berdasarkan ID
        $results = Result::where('kuis_id', $id)->with('user')->get(); // Ambil hasil kuis
        return view('results.show', compact('kuis', 'results'));
    }
    public function showResults($kuisId)
    {
        $kuis = KuisV2::findOrFail($kuisId);
        $results = Result::where('kuis_id', $kuisId)->with('user')->get();

        return view('kuisv2.results', compact('kuis', 'results'));
    }
}
