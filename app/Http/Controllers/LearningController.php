<?php

namespace App\Http\Controllers;

use App\Models\AktivitasSiswa;
use App\Models\Learning;
use App\Models\Evaluasi;
use App\Models\LearningStage1;
use App\Models\LearningStage1Result;
use App\Models\LaporanKelompok;
use App\Models\RefleksiUser;
use App\Models\Kelompok;
use App\Models\Catatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    // Fetch and display the learning index page
    public function index()
    {
        $learnings = Learning::orderBy('created_at', 'desc')->get();
        return view('learning.index', compact('learnings'));
    }

    // Store a new learning item
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Learning::create([
            'name' => $request->nama,
        ]);

        return redirect()->route('learning.index')->with('success', 'Learning added successfully.');
    }

    // Delete a learning item
    public function destroy($id)
    {
        $learning = Learning::findOrFail($id);
        $learning->delete();

        return redirect()->route('learning.index')->with('success', 'Learning deleted successfully.');
    }

    // Show a single learning item
    public function show($id)
    {
        $learning = Learning::findOrFail($id);


        // Retrieve the learning stage data (you can adjust as needed)
        $learningStage1 = LearningStage1::with('learningStage1Results.user')
            ->where('learning_id', $id)
            ->first();

        // Check if the user has already added a result
        $existingResult = $learningStage1 ? LearningStage1Result::where('learning_stage1_id', $learningStage1->id)
            ->where('user_id', auth()->id())
            ->first() : null;


        return view('learning.show', compact('learning', 'learningStage1', 'existingResult'));
    }

    // Store the stage 1 data for learning
    public function storeStage1(Request $request, $id)
    {
        $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'problem' => 'required|string|max:255',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/learning_stage1', $fileName, 'public');
        }

        LearningStage1::create([
            'learning_id' => $request->input('learning_id'),
            'problem' => $request->input('problem'),
            'file' => $filePath,
        ]);

        return redirect()->route('learning.show', ['learning' => $id])->with('success', 'Data Tahap 1 berhasil ditambahkan!');
    }

    // Store the result data for learning stage 1
    public function storeStage1Result(Request $request, $learningStage1Id)
    {
        $request->validate([
            'result' => 'required|string|max:255',
        ]);

        $learningStage1 = LearningStage1::find($learningStage1Id);

        if (!$learningStage1) {
            return redirect()->route('learning.index')
                ->with('error', 'Learning Stage 1 tidak ditemukan.');
        }

        $existingResult = LearningStage1Result::where('learning_stage1_id', $learningStage1->id)
            ->where('user_id', auth()->id())
            ->first();


        if ($existingResult) {
            return redirect()->route('learning.show', ['learning' => $learningStage1->learning_id])
                ->with('error', 'Anda hanya dapat menambahkan satu hasil identifikasi masalah.');
        }

        LearningStage1Result::create([
            'learning_stage1_id' => $learningStage1Id,
            'user_id' => auth()->user()->id,
            'result' => $request->result,
            'is_validated' => false,
        ]);

        // Simpan aktivitas siswa
        AktivitasSiswa::create([
            'user_id' => auth()->id(),
            'learning_id' => $learningStage1->learning_id,
            'tahap' => '1',
            'jenis_aktivitas' => 'Hasil Identifikasi Masalah',
            'deskripsi' => $request->result,
            'waktu_aktivitas' => now(), // bisa juga dihilangkan karena default CURRENT_TIMESTAMP
        ]);


        return redirect()->route('learning.show', ['learning' => $learningStage1->learning_id])
            ->with('success', 'Hasil Identifikasi Masalah berhasil ditambahkan!');
    }

    public function toggleValidation($id)
    {
        $result = LearningStage1Result::findOrFail($id);
        $result->is_validated = !$result->is_validated;
        $result->save();

        return back()->with('success', 'Status validasi berhasil diperbarui.');
    }

    public function validateAllResults($learningStage1Id)
    {
        LearningStage1Result::where('learning_stage1_id', $learningStage1Id)
            ->update(['is_validated' => true]);

        return redirect()->back()->with('success', 'Semua hasil identifikasi telah divalidasi.');
    }


    // Show Stage 2
    public function showStage2($learningId)
    {
        $learning = Learning::findOrFail($learningId);

        // Ambil semua kelompok yang terkait dengan learning_id dan urutkan berdasarkan created_at
        $kelompok = Kelompok::where('learning_id', $learningId)
            ->orderBy('created_at', 'desc')  // Paling baru di atas
            ->get();

        return view('learning.stage2', compact('learning', 'kelompok'));
    }

    public function showInStage2($learningId, $id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $learning = Learning::findOrFail($learningId);

        return view('kelompok.show', compact('kelompok', 'learning'));
    }




    // Store a new group (Kelompok)
    public function storeKelompok(Request $request, $learningId)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'jumlah_kelompok' => 'required|integer|min:1',
        ]);

        Kelompok::create([
            'learning_id' => $learningId,
            'nama_kelompok' => $request->nama_kelompok,
            'jumlah_kelompok' => $request->jumlah_kelompok,
        ]);

        return redirect()->route('learning.stage2', $learningId)->with('success', 'Kelompok berhasil ditambahkan!');
    }
    public function stage3($id)
    {
        $learning = Learning::findOrFail($id);

        $userRole = Auth::user()->role;

        if ($userRole === 0 || $userRole === 1) {
            // Admin atau guru, tampilkan semua catatan
            $catatanList = Catatan::where('learning_id', $id)
                ->with(['user', 'kelompok'])
                ->get();

            $kelompok = null; // Admin dan guru mungkin gak perlu kelompok spesifik
        } else {
            // User biasa, tampilkan catatan sesuai kelompok dan user
            $kelompok = Auth::user()->kelompokBelajar()->wherePivot('learning_id', $id)->first();

            $catatanList = Catatan::where('learning_id', $id)
                ->where('user_id', Auth::id())
                ->when($kelompok, function ($query) use ($kelompok) {
                    return $query->where('kelompok_id', $kelompok->id);
                })
                ->with('user')
                ->get();
        }

        return view('learning.stage3', compact('learning', 'kelompok', 'catatanList'));
    }

    public function stage4($id)
    {
        $user = auth()->user();

        // Ambil learning
        $learning = Learning::findOrFail($id);

        $kelompok = null;
        $laporan = collect(); // Default kosong

        if ($user->role === 0 || $user->role === 1) {
            // Admin atau Guru: ambil semua laporan dari seluruh kelompok dalam learning ini
            $laporan = \App\Models\LaporanKelompok::whereIn('kelompok_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('kelompok')
                    ->where('learning_id', $id);
            })->with(['kelompok', 'uploader'])->get();
        } else {
            // User biasa: ambil hanya laporan dari kelompoknya
            $userKelompok = \App\Models\UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $learning->id)
                ->first();

            if ($userKelompok) {
                $kelompok = \App\Models\Kelompok::with(['catatan.user'])
                    ->find($userKelompok->kelompok_id);

                $laporan = \App\Models\LaporanKelompok::where('kelompok_id', $userKelompok->kelompok_id)
                    ->with(['kelompok', 'uploader'])
                    ->get();
            }
        }

        return view('learning.stage4', compact('learning', 'kelompok', 'laporan'));
    }



    public function showStage5($id)
    {
        $learning = Learning::findOrFail($id);

        // Ambil refleksi seperti sebelumnya
        $existingRefleksi = RefleksiUser::where('user_id', auth()->id())
            ->where('learning_id', $learning->id)
            ->first();

        $semuaRefleksi = RefleksiUser::where('learning_id', $learning->id)->with('user')->get();

        // Ambil role user login
        $userRole = auth()->user()->role;

        if (in_array($userRole, [0, 1])) {
            // Jika admin (0) atau guru (1), ambil semua kelompok di learning
            $kelompok = Kelompok::where('learning_id', $learning->id)
                ->with('anggota.user')
                ->get();
        } else {
            // Jika user biasa, ambil kelompok yang user itu anggotanya
            $kelompok = Kelompok::where('learning_id', $learning->id)
                ->whereHas('anggota', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->with('anggota.user')
                ->get();
        }

        // Ambil evaluasi untuk kelompok-kelompok tersebut
        $evaluasi = Evaluasi::where('learning_id', $learning->id)
            ->whereIn('kelompok_id', $kelompok->pluck('id'))
            ->get()
            ->groupBy('kelompok_id');

        return view('learning.stage5', compact('learning', 'existingRefleksi', 'semuaRefleksi', 'kelompok', 'evaluasi'));
    }
    public function selesaikan($learningId)
    {
        $learning = Learning::findOrFail($learningId);

        $learning->is_completed = true;  // Ubah status jadi completed
        $learning->save();               // Simpan perubahan

        return redirect()->route('learning.index')
            ->with('learning_completed', true);
    }

    public function activity($learningId)
    {
        $learning = Learning::findOrFail($learningId);
        // bisa kirim data lain sesuai kebutuhan ke view aktivitas
        return view('aktivitas', compact('learning'));
    }
}
