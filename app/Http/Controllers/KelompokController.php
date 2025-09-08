<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Learning;
use App\Models\UserKelompokLearning;
use App\Models\PenugasanUser;
use App\Models\AktivitasSiswa;

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
    public function destroy($learningId, $id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $kelompok->delete();

        return redirect()->route('learning.stage2', ['learningId' => $learningId])
            ->with('success', 'Kelompok berhasil dihapus.');
    }



    // Menampilkan detail kelompok
    public function show($learningId, $kelompokId)
    {
        $learning = Learning::findOrFail($learningId);
        $kelompok = Kelompok::with(['anggota.user'])->findOrFail($kelompokId);

        // Ambil semua penugasan untuk kelompok ini
        $penugasans = PenugasanUser::where('learning_id', $learningId)
            ->where('kelompok_id', $kelompokId)
            ->get();

        // dd($penugasans); // Hapus ini jika sudah tidak perlu

        return view('kelompok.show', compact('learning', 'kelompok', 'penugasans'));
    }




    // Menampilkan halaman kelompok di stage 2 dan memeriksa apakah user sudah bergabung
    public function showInStage2($learningId, $id)
    {
        $kelompok = Kelompok::with('anggota')->findOrFail($id);
        $learning = Learning::findOrFail($learningId);
        $user = auth()->user();

        if ($user->role == 2) {
            $existing = UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $learning->id)
                ->first();

            if ($existing && $existing->kelompok_id != $kelompok->id) {
                return redirect()->route('kelompok.stage2.show', [
                    'learning' => $learning->id,
                    'id' => $existing->kelompok_id
                ])->with('error', 'Anda hanya dapat mengakses satu kelompok di learning ini.');
            }
        }

        $penugasans = PenugasanUser::with('user')
            ->where('learning_id', $learningId)
            ->where('kelompok_id', $id)
            ->get();

        return view('kelompok.show', compact('kelompok', 'learning', 'penugasans'));
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
        $user = auth()->user();

        $sudahGabung = UserKelompokLearning::where('user_id', $user->id)
            ->where('kelompok_id', $kelompokId)
            ->exists();

        if ($sudahGabung) {
            return redirect()->route('kelompok.stage2.show', [
                'learning' => $request->learning_id,
                'id' => $kelompokId
            ])->with('success', 'Berhasil bergabung!');
        }

        // Hitung anggota real-time langsung dari DB
        $jumlahAnggota = UserKelompokLearning::where('kelompok_id', $kelompokId)->count();

        if ($kelompok->countAnggota() >= $kelompok->jumlah_kelompok) {
            return redirect()->back()->with('error', 'Kelompok ini sudah penuh.');
        }


        UserKelompokLearning::create([
            'user_id' => $user->id,
            'kelompok_id' => $kelompokId,
            'learning_id' => $request->learning_id,
        ]);

        // Simpan aktivitas siswa tahap 2 gabung kelompok
        AktivitasSiswa::create([
            'user_id' => $user->id,
            'learning_id' => $kelompok->learning_id,
            'tahap' => '2',
            'jenis_aktivitas' => 'Gabung Kelompok',
            'deskripsi' => 'User bergabung ke kelompok ' . $kelompok->nama_kelompok,
            'waktu_aktivitas' => now(),
        ]);
        // Increment terisi di kelompok
        $kelompok->increment('terisi');


        return redirect()->route('kelompok.stage2.show', [
            'learning' => $request->learning_id,
            'id' => $kelompokId,
        ])->with('success', 'Anda berhasil bergabung di kelompok.');
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

    // Menyimpan penugasan
    public function storePenugasan(Request $request)
    {
        // Validasi input
        $request->validate([
            'penugasan' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,ppt,pptx|max:10240', // Sesuaikan ekstensi file
        ]);

        // Simpan file
        $filePath = $request->file('file')->store('penugasans', 'public');

        // Simpan data penugasan
        PenugasanUser::create([
            'user_id' => auth()->id(),
            'learning_id' => $request->learning_id,
            'kelompok_id' => $request->kelompok_id,
            'penugasan' => $request->penugasan,
            'file' => $filePath,
        ]);
        AktivitasSiswa::create([
            'user_id' => auth()->id(),
            'learning_id' => $request->learning_id,
            'tahap' => '2',
            'jenis_aktivitas' => 'Menambahkan Penugasan',
            'deskripsi' => 'Menambahkan penugasan: ' . $request->penugasan,
            'waktu_aktivitas' => now(),
        ]);


        return redirect()->route('kelompok.stage2.show', [
            'learning' => $request->learning_id,
            'id' => $request->kelompok_id
        ])->with('success', 'Penugasan berhasil diunggah!');
    }
}
