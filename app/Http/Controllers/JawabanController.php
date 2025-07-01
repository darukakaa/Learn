<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jawaban;
use App\Models\Soal;
use App\Models\NilaiTes;
use Illuminate\Support\Facades\Auth;

class JawabanController extends Controller
{
    /**
     * Simpan jawaban dari siswa.
     */
    public function store(Request $request)
    {
        $userId = auth()->id();
        $tesId = $request->input('tes_id');
        $answers = $request->input('jawaban');

        $totalNilai = 0;

        foreach ($answers as $soalId => $jawabanUser) {
            $soal = Soal::find($soalId);

            // Simpan jawaban dengan menyertakan tes_soal_id
            Jawaban::updateOrCreate(
                [
                    'user_id' => $userId,
                    'soal_id' => $soalId,
                    'tes_soal_id' => $tesId
                ],
                [
                    'pilihan_jawaban' => $jawabanUser
                ]
            );

            // Hitung bobot nilai jika jawaban benar
            if (strtoupper($jawabanUser) === strtoupper($soal->jawaban_benar)) {
                $totalNilai += $soal->bobot_nilai;
            }
        }

        // Simpan total nilai ke tabel nilaites
        NilaiTes::updateOrCreate(
            ['user_id' => $userId, 'tes_soals_id' => $tesId],
            ['nilai' => $totalNilai]
        );

        return redirect()->route('tes_soal.index')->with('success', 'Jawaban berhasil disimpan dan nilai dihitung.');
    }
}
