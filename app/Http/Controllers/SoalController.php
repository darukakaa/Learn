<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Opsi;
use Illuminate\Support\Facades\Storage;

class SoalController extends Controller
{
    // Tampilkan daftar soal berdasarkan tes_id
    public function index($tesId)
    {
        $soals = Soal::where('tes_soals_id', $tesId)->get();
        return view('tes-soal.show', compact('soals', 'tesId'));
    }

    // Simpan soal baru
    public function store(Request $request, $tesId)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'pilihan_e' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D,E',
            'bobot_nilai' => 'required|integer|min:1|max:10',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $soal = new Soal();
        $soal->tes_soals_id = $tesId;
        $soal->pertanyaan = $request->pertanyaan;
        $soal->pilihan_a = $request->pilihan_a;
        $soal->pilihan_b = $request->pilihan_b;
        $soal->pilihan_c = $request->pilihan_c;
        $soal->pilihan_d = $request->pilihan_d;
        $soal->pilihan_e = $request->pilihan_e;
        $soal->jawaban_benar = $request->jawaban_benar;
        $soal->bobot_nilai = $request->bobot_nilai;

        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('soal_gambar', 'public');
            $soal->gambar = $path;
        }

        $soal->save();
        foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {
            Opsi::create([
                'soal_id' => $soal->id,
                'opsi' => $opt,
                'jawaban_teks' => $request->{'pilihan_' . strtolower($opt)},
                'is_correct' => $opt === $request->jawaban_benar ? true : false,
            ]);
        }
        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'pilihan_e' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D,E',
            'bobot_nilai' => 'required|integer|min:1|max:10',
        ]);

        $soal = Soal::findOrFail($id);
        $soal->pertanyaan = $request->pertanyaan;
        $soal->pilihan_a = $request->pilihan_a;
        $soal->pilihan_b = $request->pilihan_b;
        $soal->pilihan_c = $request->pilihan_c;
        $soal->pilihan_d = $request->pilihan_d;
        $soal->pilihan_e = $request->pilihan_e;
        $soal->jawaban_benar = $request->jawaban_benar;
        $soal->bobot_nilai = $request->bobot_nilai;

        $soal->save();

        return redirect()->back()->with('success', 'Soal berhasil diperbarui.');
    }
    // Tampilkan form edit soal
    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        return view('soal.edit', compact('soal'));
    }

    // Hapus soal
    public function destroy($id)
    {
        $soal = Soal::findOrFail($id);

        // Hapus gambar jika ada
        if ($soal->gambar) {
            Storage::disk('public')->delete($soal->gambar);
        }

        // Hapus opsi terkait (jika kamu punya relasi)
        $soal->opsi()->delete();

        $soal->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }
}
