<?php

namespace App\Http\Controllers;


use App\Models\AktivitasSiswa;
use App\Models\Catatan;
use App\Models\Learning;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanController extends Controller
{
    public function index($learningId)
    {
        $learning = Learning::findOrFail($learningId);

        $kelompok = Kelompok::where('user_id', Auth::id())
            ->where('learning_id', $learningId)
            ->first();

        $catatanList = Catatan::where('learning_id', $learningId)
            ->with(['user', 'kelompok'])
            ->get();


        return view('learning.stage3', compact('learning', 'kelompok', 'catatanList'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'isi_catatan' => 'required|string',
            'file_catatan' => 'required|file|max:2048',
            'learning_id' => 'required|exists:learnings,id',
            'kelompok_id' => 'required|exists:kelompok,id',
        ]);

        $catatan = new Catatan();
        $catatan->isi_catatan = $request->isi_catatan;
        $catatan->learning_id = $request->learning_id;
        $catatan->kelompok_id = $request->kelompok_id;
        $catatan->user_id = Auth::id();

        if ($request->hasFile('file_catatan')) {
            $filePath = $request->file('file_catatan')->store('catatan_files', 'public');
            $catatan->file_catatan = $filePath;
        }

        $catatan->save();
        // Simpan aktivitas siswa tahap 3 - menambahkan catatan
        AktivitasSiswa::create([
            'user_id' => Auth::id(),
            'learning_id' => $request->learning_id,
            'tahap' => '3',
            'jenis_aktivitas' => 'Menambahkan Catatan',
            'deskripsi' => 'Catatan: ' . substr($request->isi_catatan, 0, 50), // potong deskripsi agar ringkas
            'waktu_aktivitas' => now(),
        ]);
        return redirect()->back()->with('success', 'Catatan berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'isi_catatan' => 'required|string',
            'file_catatan' => 'nullable|file|max:2048',
        ]);

        $catatan = Catatan::findOrFail($id);
        $catatan->isi_catatan = $request->isi_catatan;

        if ($request->hasFile('file_catatan')) {
            $filePath = $request->file('file_catatan')->store('catatan_files', 'public');
            $catatan->file_catatan = $filePath;
        }

        $catatan->save();


        return redirect()->back()->with('success', 'Catatan berhasil diperbarui.');
    }

    public function toggleValidate($id)
    {
        // Pastikan user yang mengakses adalah admin atau guru
        if (!in_array(auth()->user()->role, [0, 1])) {
            abort(403, 'Unauthorized');
        }

        $catatan = Catatan::findOrFail($id);
        $catatan->is_validated = !$catatan->is_validated; // toggle status
        $catatan->save();

        $message = $catatan->is_validated ? 'Catatan berhasil divalidasi.' : 'Validasi catatan dibatalkan.';

        return redirect()->back()->with('success', $message);
    }
}
