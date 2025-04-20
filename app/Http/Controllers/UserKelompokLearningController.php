<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserKelompokLearning;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserKelompokLearningController extends Controller
{
    public function store($learningId, $kelompokId)
    {
        $user = auth()->user();

        // Cek apakah user sudah tergabung dalam kelompok untuk learning ini
        $existing = DB::table('user_kelompok_learning')
            ->where('user_id', $user->id)
            ->where('learning_id', $learningId)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah tergabung dalam kelompok di learning ini.');
        }

        // Cek apakah kelompok sudah penuh
        $jumlahSaatIni = DB::table('user_kelompok_learning')
            ->where('kelompok_id', $kelompokId)
            ->count();

        $kelompok = Kelompok::findOrFail($kelompokId);
        if ($jumlahSaatIni >= $kelompok->jumlah_kelompok) {
            return redirect()->back()->with('error', 'Kelompok sudah penuh.');
        }

        // Simpan data
        DB::table('user_kelompok_learning')->insert([
            'user_id' => $user->id,
            'learning_id' => $learningId,
            'kelompok_id' => $kelompokId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Berhasil bergabung ke kelompok.');
    }
}
