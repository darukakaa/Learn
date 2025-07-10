<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Materiv2;

class Materiv2Controller extends Controller
{
    public function index()
    {
        $jumlahMateriv2 = Materiv2::count();
        $jumlahMateriv2 = \App\Models\Materiv2::count();
        $materi = Materiv2::orderBy('created_at', 'desc')->get();
        return view('materiv2.index', compact('materi', 'jumlahMateriv2'));
    }
    public function show($id)
    {
        $materi = \App\Models\Materiv2::findOrFail($id);
        return view('materiv2.show', compact('materi'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        Materiv2::create($request->only('nama_materi', 'tanggal'));

        return redirect()->route('materiv2.index')->with('success', 'Materi berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $materi = Materiv2::findOrFail($id);

        $validated = $request->validate([
            'deskripsi' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'capaian' => 'nullable|string',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        $materi->deskripsi = $request->deskripsi;
        $materi->tujuan = $request->tujuan;
        $materi->capaian = $request->capaian;

        if ($request->hasFile('file_pdf')) {
            $filePath = $request->file('file_pdf')->store('materiv2_pdf', 'public');
            $materi->file_pdf = $filePath;
        }

        $materi->save();

        return redirect()->route('materiv2.show', $materi->id)->with('success', 'Materi berhasil diperbarui.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('materiv2_gambar', 'public');

            return response()->json([
                'uploaded' => true,
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['uploaded' => false, 'error' => ['message' => 'No file uploaded.']], 400);
    }
    public function destroy($id)
    {
        $materi = Materiv2::findOrFail($id);

        // Hapus file PDF jika ada
        if ($materi->file_pdf && \Storage::disk('public')->exists($materi->file_pdf)) {
            \Storage::disk('public')->delete($materi->file_pdf);
        }

        $materi->delete();

        return redirect()->route('materiv2.index')->with('success', 'Materi berhasil dihapus.');
    }
}
