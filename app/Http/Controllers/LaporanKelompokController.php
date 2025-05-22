<?php

namespace App\Http\Controllers;

use App\Models\LaporanKelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanKelompokController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf,doc,docx,pptx,zip',
            'kelompok_id' => 'required|exists:kelompok,id',
        ]);

        // Upload file
        $file = $request->file('file_laporan');
        $filePath = $file->store('laporan_kelompok', 'public');

        // Cari learning_id dari kelompok_id
        $kelompok = \App\Models\Kelompok::findOrFail($request->kelompok_id);

        // Simpan ke DB
        LaporanKelompok::create([
            'kelompok_id' => $request->kelompok_id,
            'uploaded_by' => auth()->id(),
            'file_path' => $filePath,
            'is_validated' => false,
            'user_id' => auth()->id(),               // tambah user_id
            'learning_id' => $kelompok->learning_id, // tambah learning_id
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil diupload.');
    }

    public function validasi($id)
    {
        $laporan = \App\Models\LaporanKelompok::findOrFail($id);

        // Toggle validasi
        $laporan->is_validated = !$laporan->is_validated;
        $laporan->save();

        return back()->with('success', 'Status validasi berhasil diperbarui.');
    }
    public function beriNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
        ]);

        $laporan = LaporanKelompok::findOrFail($id);
        $nilai = $request->nilai;

        // Hitung kriteria
        if ($nilai <= 20) {
            $kriteria = 'Kurang Sekali';
        } elseif ($nilai <= 40) {
            $kriteria = 'Kurang';
        } elseif ($nilai <= 60) {
            $kriteria = 'Sedang';
        } elseif ($nilai <= 80) {
            $kriteria = 'Baik';
        } else {
            $kriteria = 'Sangat Baik';
        }

        $laporan->update([
            'nilai' => $nilai,
            'kriteria' => $kriteria,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf,docx,pptx|max:20480',
        ]);

        $laporan = LaporanKelompok::findOrFail($id);

        if ($laporan->is_validated) {
            return redirect()->back()->with('error', 'Laporan yang sudah divalidasi tidak dapat diubah.');
        }
        // Hapus file lama jika ada
        if ($laporan->file_path && \Storage::exists('public/' . $laporan->file_path)) {
            \Storage::delete('public/' . $laporan->file_path);
        }

        // Simpan file baru
        $path = $request->file('file_laporan')->store('laporan_kelompok', 'public');

        // Update data
        $laporan->update([
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'File laporan berhasil diperbarui.');
    }
}
