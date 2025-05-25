<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasSiswa;
use App\Models\Learning;

class AktivitasSiswaController extends Controller
{
    public function index($learningId)
    {
        $learning = Learning::findOrFail($learningId);

        $aktivitas = AktivitasSiswa::where('learning_id', $learningId)
            ->with('user')
            ->latest()
            ->get();

        return view('aktivitas', compact('aktivitas', 'learning'));
    }
}
