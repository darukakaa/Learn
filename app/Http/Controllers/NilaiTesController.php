<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\TesSoal;
use App\Models\Soal;

use Illuminate\Http\Request;

class NilaiTesController extends Controller
{
    public function siswa($tesSoalId)
    {
        $tes = TesSoal::findOrFail($tesSoalId);
        $dataNilai = Jawaban::with('user', 'soal')
            ->whereIn('soal_id', Soal::where('tes_soals_id', $tesSoalId)->pluck('id'))
            ->get()
            ->groupBy('user_id');

        return view('nilai_tes.siswa', compact('tes', 'dataNilai'));
    }

    public function index($userId, $tesSoalId)
    {
        // Ambil semua jawaban user untuk tes tersebut
        $jawabanUser = Jawaban::with('soal')
            ->where('user_id', $userId)
            ->whereHas('soal', function ($query) use ($tesSoalId) {
                $query->where('tes_soals_id', $tesSoalId);
            })
            ->get()
            ->keyBy('soal_id'); // Agar lebih mudah dicek berdasarkan ID soal

        // Ambil semua soal dari tes ini
        $soals = Soal::where('tes_soals_id', $tesSoalId)->get();

        // Hitung total nilai
        $totalNilai = 0;
        foreach ($soals as $soal) {
            if (isset($jawabanUser[$soal->id]) && $jawabanUser[$soal->id]->pilihan_jawaban === $soal->jawaban_benar) {
                $totalNilai += $soal->bobot_nilai;
            }
        }

        return view('nilai_tes.index', compact('totalNilai', 'jawabanUser', 'soals'));
    }
}
