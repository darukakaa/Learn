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
}
