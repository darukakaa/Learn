<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Learning;
use App\Models\UserKelompokLearning;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    // Menampilkan form kelompok
    public function showForm($learningId, $stageId)
    {
        // Mengambil semua kelompok berdasarkan learningId dan stageId
        $kelompok = Kelompok::where('learning_id', $learningId)
            ->where('stage_id', $stageId)
            ->get();

        // Mengirimkan data ke view
        return view('kelompok.show', compact('kelompok', 'learningId', 'stageId'));
    }

    // Method untuk menghapus kelompok
    public function destroy($id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $kelompok->delete();

        return redirect()->back()->with('success', 'Kelompok berhasil dihapus!');
    }

    // Menampilkan detail kelompok
    public function show($id)
    {
        $kelompok = Kelompok::with('anggota')->findOrFail($id);
        $learning = Learning::findOrFail($kelompok->learning_id); // ambil learning dari kelompok

        return view('kelompok.show', compact('kelompok', 'learning'));
    }


    // Menampilkan halaman kelompok di stage 2 dan memeriksa apakah user sudah bergabung
    public function showInStage2($learningId, $id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $learning = Learning::findOrFail($learningId);
        $user = auth()->user();

        // Cek apakah user sudah tergabung dalam kelompok pada learning ini
        if ($user->role == 2) {
            $existing = UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $learning->id)
                ->first();

            // Jika sudah tergabung tapi bukan kelompok ini, redirect ke kelompok yang benar
            if ($existing && $existing->kelompok_id != $kelompok->id) {
                return redirect()->route('kelompok.stage2.show', [
                    'learning' => $learning->id, // <- disesuaikan dari 'learningId' ke 'learning'
                    'id' => $existing->kelompok_id
                ])->with('error', 'Anda hanya dapat mengakses satu kelompok di learning ini.');
            }
        }

        return view('kelompok.show', compact('kelompok', 'learning'));
    }


    // Memilih kelompok bagi user
    public function pilihKelompok($kelompokId)
    {
        $kelompok = Kelompok::findOrFail($kelompokId);
        $user = auth()->user();

        // Pastikan hanya user dengan role 'user' yang belum memilih kelompok yang bisa memilih
        if ($user->role === 'user' && is_null($user->kelompok_id)) {
            $user->kelompok_id = $kelompok->id;
            $user->save();

            return redirect()->route('kelompok.show', $kelompok->id)
                ->with('success', 'Anda telah memilih kelompok ini!');
        }

        return redirect()->route('kelompok.show', $kelompok->id)
            ->with('error', 'Anda sudah memilih kelompok atau tidak diperbolehkan memilih kelompok!');
    }

    // Mengelola anggota kelompok
    public function manage($learningId, $kelompokId)
    {
        $learning = Learning::findOrFail($learningId);
        $kelompok = Kelompok::with('anggota')->findOrFail($kelompokId);

        return view('kelompok.manage', compact('kelompok', 'learning'));
    }

    // Menyimpan user yang bergabung ke kelompok
    public function storeUser(Request $request, $kelompokId)
    {
        $kelompok = Kelompok::findOrFail($kelompokId);
        $user = auth()->user();  // Mendapatkan user yang sedang login

        // Cek jika user sudah tergabung dalam kelompok ini
        $sudahGabung = UserKelompokLearning::where('user_id', $user->id)
            ->where('kelompok_id', $kelompokId)
            ->exists();

        if ($sudahGabung) {
            return redirect()->route('kelompok.show', ['id' => $kelompokId])
                ->with('info', 'Anda sudah tergabung dalam kelompok ini.');
        }

        // Cek jika jumlah anggota sudah penuh
        if ($kelompok->anggota->count() >= $kelompok->jumlah_kelompok) {
            return redirect()->back()->with('error', 'Kelompok ini sudah penuh.');
        }

        // Menambahkan user ke kelompok (menggunakan tabel pivot)
        UserKelompokLearning::create([
            'user_id' => $user->id,
            'kelompok_id' => $kelompokId,
            'learning_id' => $request->learning_id,
        ]);

        // Update kolom terisi
        $kelompok->increment('terisi');

        return redirect()->route('kelompok.show', ['id' => $kelompokId])
            ->with('success', 'Anda berhasil bergabung dengan kelompok!');
    }



    // Menyimpan kelompok baru
    public function store(Request $request, $learningId, $stageId)
    {
        // Validasi form
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'jumlah_kelompok' => 'required|integer|min:1|max:5',
        ]);

        // Menyimpan kelompok baru
        Kelompok::create([
            'nama_kelompok' => $request->nama_kelompok,
            'jumlah_kelompok' => $request->jumlah_kelompok,
            'learning_id' => $learningId,
            'stage_id' => $stageId,
        ]);

        // Mengambil kembali data kelompok setelah disimpan
        $kelompok = Kelompok::where('learning_id', $learningId)
            ->where('stage_id', $stageId)
            ->get();

        // Redirect kembali ke halaman yang sama (stage2.blade.php)
        return redirect()->route('learning.stage', ['learningId' => $learningId, 'stageId' => $stageId])
            ->with('success', 'Kelompok berhasil ditambahkan')
            ->with(compact('kelompok', 'learningId', 'stageId')); // Menambahkan $kelompok di sini
    }
}
