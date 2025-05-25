<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasSiswa;
use App\Models\PenugasanUser;
use App\Models\Kelompok;
use App\Models\Learning;
use Illuminate\Support\Facades\Log;

class PenugasanUserController extends Controller
{

    public function show($learningId, $kelompokId)
    {
        $kelompok = Kelompok::with('anggota.user')->findOrFail($kelompokId);
        $learning = Learning::findOrFail($learningId);

        // Ambil penugasan untuk user yang sedang login
        $penugasans = PenugasanUser::where('user_id', auth()->id())
            ->where('learning_id', $learningId)
            ->where('kelompok_id', $kelompokId)
            ->get();

        // Debug data penugasan yang dikirim ke view
        dd($penugasans);

        return view('kelompok.show', compact('kelompok', 'learning', 'penugasans'));
    }


    public function index()
    {
        $penugasans = [];

        if (auth()->user()->role == '0') {
            $penugasans = PenugasanUser::all();
        } elseif (auth()->user()->role == '2') {
            $penugasans = PenugasanUser::where('user_id', auth()->id())->get();
        }

        // Kamu bisa dummy nilai `kelompok` dan `learning` jika nggak dibutuhkan
        $kelompok = null;
        $learning = null;
        dd($penugasans);

        return view('kelompok.show', compact('penugasans', 'kelompok', 'learning'));
    }


    public function store(Request $request)
    {
        // Validasi input terlebih dahulu
        $validated = $request->validate([
            'nama_penugasan' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,pptx,jpg,jpeg,png', // Pastikan format file sudah sesuai
            'kelompok_id' => 'required|exists:kelompok,id',
            'learning_id' => 'required|exists:learnings,id',
        ]);

        // Simpan penugasan ke database
        $penugasan = new PenugasanUser();
        $penugasan->user_id = auth()->id();
        $penugasan->kelompok_id = $request->kelompok_id;
        $penugasan->learning_id = $request->learning_id;
        $penugasan->nama_penugasan = $request->nama_penugasan;

        // Menyimpan file, jika ada
        if ($request->hasFile('file')) {
            // Simpan file ke folder public storage
            $penugasan->file = $request->file('file')->store('penugasan_files', 'public');
        }

        // Simpan penugasan ke database
        $penugasan->save();
        // Simpan aktivitas siswa untuk tahap 2 menambah penugasan
        AktivitasSiswa::create([
            'user_id' => auth()->id(),
            'learning_id' => $request->learning_id,
            'tahap' => '2',
            'jenis_aktivitas' => 'Menambahkan Penugasan',
            'deskripsi' => 'Penugasan: ' . $request->nama_penugasan,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->back()->with('success', 'Penugasan berhasil ditambahkan!');
    }
}
