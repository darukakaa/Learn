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
        $user = auth()->user();
        $role = $user->role;

        // Ambil semua learning dan hitung progress untuk tiap learning
        $learnings = Learning::orderBy('created_at', 'desc')->get()->map(function ($learning) use ($user) {
            $progress = 0;

            // Tahap 1
            $stage1 = \App\Models\LearningStage1::where('learning_id', $learning->id)->first();
            if ($stage1) {
                $result = \App\Models\LearningStage1Result::where('learning_stage1_id', $stage1->id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($result && $result->is_validated) {
                    $progress += 20;
                }
            }

            // Tahap 2 (user gabung kelompok)
            $userKelompok = \App\Models\UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $learning->id)
                ->first();
            if ($userKelompok) {
                $progress += 20;
            }

            // Tahap 3 (catatan)
            $catatan = \App\Models\Catatan::where('learning_id', $learning->id)
                ->where('user_id', $user->id)
                ->exists();
            if ($catatan) {
                $progress += 20;
            }

            // Tahap 4 (laporan kelompok tervalidasi)
            $laporan = \App\Models\LaporanKelompok::whereIn('kelompok_id', function ($query) use ($learning) {
                $query->select('id')
                    ->from('kelompok')
                    ->where('learning_id', $learning->id);
            })
                ->where('is_validated', true)
                ->exists();
            if ($laporan) {
                $progress += 20;
            }

            // Tahap 5 (refleksi user submit)
            $refleksi = \App\Models\RefleksiUser::where('learning_id', $learning->id)
                ->where('user_id', $user->id)
                ->exists();
            if ($refleksi) {
                $progress += 20;
            }

            // Tambahkan property progress ke objek learning
            $learning->progress = $progress;
            return $learning;
        });

        return view('learning.index', compact('learnings', 'role'));
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
        $userId = auth()->id();

        // Tahap 1
        $learningStage1 = LearningStage1::with('learningStage1Results.user')
            ->where('learning_id', $id)
            ->first();

        $existingResult = $learningStage1 ? LearningStage1Result::where('learning_stage1_id', $learningStage1->id)
            ->where('user_id', $userId)
            ->first() : null;

        // Hitung progress
        $validatedStages = 0;

        // Tahap 1 (identifikasi masalah tervalidasi)
        if ($existingResult && $existingResult->is_validated) {
            $validatedStages++;
        }

        // Tahap 2 (sudah join kelompok)
        if (\App\Models\UserKelompokLearning::where('learning_id', $learning->id)
            ->where('user_id', $userId)
            ->exists()
        ) {
            $validatedStages++;
        }

        // Tahap 3 (sudah buat catatan)
        if (\App\Models\Catatan::where('learning_id', $learning->id)
            ->where('user_id', $userId)
            ->exists()
        ) {
            $validatedStages++;
        }

        // Tahap 4 (laporan kelompok sudah divalidasi)
        if (\App\Models\LaporanKelompok::where('learning_id', $learning->id)
            ->where('is_validated', true)
            ->whereHas('kelompok.anggota', fn($q) => $q->where('user_id', $userId))
            ->exists()
        ) {
            $validatedStages++;
        }

        // Tahap 5 (sudah submit refleksi)
        if (\App\Models\RefleksiUser::where('learning_id', $learning->id)
            ->where('user_id', $userId)
            ->exists()
        ) {
            $validatedStages++;
        }

        // Hitung progres akhir
        $progress = ($validatedStages / 5) * 100;

        return view('learning.show', compact(
            'learning',
            'learningStage1',
            'existingResult',
            'progress'
        ));
    }



    // Store the stage 1 data for learning
    public function storeStage1(Request $request, $id)
    {
        $request->validate([
            'learning_id' => 'required|exists:learnings,id',
            'problem' => 'required|string|max:255',
            // Ubah bagian validasi file:
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            // max:5120 = 5MB, bisa kamu sesuaikan
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Simpan di folder yang sama
            $filePath = $file->storeAs('uploads/learning_stage1', $fileName, 'public');
        }

        LearningStage1::create([
            'learning_id' => $request->input('learning_id'),
            'problem' => $request->input('problem'),
            'file' => $filePath,
        ]);

        return redirect()
            ->route('learning.show', ['learning' => $id])
            ->with('success', 'Data Tahap 1 berhasil ditambahkan!');
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



    public function showStage2($learningId)
    {
        $learning = Learning::findOrFail($learningId);

        // Ambil semua kelompok yang terkait dengan learning_id dan urutkan berdasarkan created_at
        $kelompok = Kelompok::where('learning_id', $learningId)
            ->orderBy('created_at', 'desc')
            ->get();

        $user = auth()->user();
        $progress = 0;
        $totalStages = 5;
        $perStage = 100 / $totalStages;

        if ($user) {
            // --- Tahap 1: cek identifikasi masalah sudah divalidasi ---
            $stage1 = \App\Models\LearningStage1Result::where('user_id', $user->id)
                ->whereHas('learningStage1', function ($q) use ($learningId) {
                    $q->where('learning_id', $learningId);
                })
                ->first();

            if ($stage1 && $stage1->is_validated) {
                $progress += $perStage;
            }

            // --- Tahap 2: cek apakah sudah gabung kelompok ---
            $isJoined = \App\Models\UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $learningId)
                ->exists();

            if ($isJoined) {
                $progress += $perStage;
            }

            // --- Tahap 3: cek apakah user sudah buat catatan ---
            if (\App\Models\Catatan::where('learning_id', $learningId)
                ->where('user_id', $user->id)
                ->exists()
            ) {
                $progress += $perStage;
            }

            // --- Tahap 4: cek apakah laporan kelompok user sudah divalidasi ---
            if (\App\Models\LaporanKelompok::where('learning_id', $learningId)
                ->where('is_validated', true)
                ->whereHas('kelompok.anggota', fn($q) => $q->where('user_id', $user->id))
                ->exists()
            ) {
                $progress += $perStage;
            }

            // --- Tahap 5: cek apakah user sudah submit refleksi ---
            if (\App\Models\RefleksiUser::where('learning_id', $learningId)
                ->where('user_id', $user->id)
                ->exists()
            ) {
                $progress += $perStage;
            }
        }

        return view('learning.stage2', compact('learning', 'kelompok', 'progress'));
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

        $user = Auth::user();
        $userRole = $user->role;

        // Default progress
        $progress = 0;
        $totalStages = 5; // total ada 5 tahap
        $perStage = 100 / $totalStages;

        if ($userRole === 0 || $userRole === 1) {
            // Admin atau guru, tampilkan semua catatan
            $catatanList = Catatan::where('learning_id', $id)
                ->with(['user', 'kelompok'])
                ->get();

            $kelompok = null;
        } else {
            // User biasa
            $kelompok = $user->kelompokBelajar()->wherePivot('learning_id', $id)->first();

            $catatanList = Catatan::where('learning_id', $id)
                ->where('user_id', $user->id)
                ->when($kelompok, function ($query) use ($kelompok) {
                    return $query->where('kelompok_id', $kelompok->id);
                })
                ->with('user')
                ->get();


            // --- Tahap 1: identifikasi masalah tervalidasi ---
            $stage1 = \App\Models\LearningStage1Result::where('user_id', $user->id)
                ->whereHas('learningStage1', function ($q) use ($id) {
                    $q->where('learning_id', $id);
                })
                ->first();

            if ($stage1 && $stage1->is_validated) {
                $progress += $perStage;
            }

            // --- Tahap 2: sudah gabung kelompok ---
            $isJoined = \App\Models\UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $id)
                ->exists();

            if ($isJoined) {
                $progress += $perStage;
            }

            // --- Tahap 3: catatan tervalidasi ---
            $validatedCatatan = Catatan::where('learning_id', $id)
                ->where('user_id', $user->id)
                ->when($kelompok, function ($query) use ($kelompok) {
                    return $query->where('kelompok_id', $kelompok->id);
                })
                ->where('is_validated', true)
                ->exists();

            if ($validatedCatatan) {
                $progress += $perStage;
            }

            // --- Tahap 4: laporan kelompok tervalidasi ---
            $laporan = \App\Models\LaporanKelompok::where('kelompok_id', optional($kelompok)->id)
                ->where('learning_id', $id)
                ->where('is_validated', true)
                ->exists();

            if ($laporan) {
                $progress += $perStage;
            }

            // --- Tahap 5: refleksi sudah submit ---
            $refleksi = \App\Models\RefleksiUser::where('learning_id', $id)
                ->where('user_id', $user->id)
                ->exists();

            if ($refleksi) {
                $progress += $perStage;
            }
        }

        return view('learning.stage3', compact('learning', 'kelompok', 'catatanList', 'progress'));
    }



    public function stage4($id)
    {
        $user = auth()->user();

        // Ambil learning
        $learning = Learning::findOrFail($id);

        $kelompok = null;
        $laporan = collect(); // Default kosong
        $progress = 0; // Default progress
        $totalStages = 5;
        $perStage = 100 / $totalStages;

        if ($user->role === 0 || $user->role === 1) {
            // Admin atau Guru: ambil semua laporan dari seluruh kelompok dalam learning ini
            $laporan = \App\Models\LaporanKelompok::whereIn('kelompok_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('kelompok')
                    ->where('learning_id', $id);
            })->with(['kelompok', 'uploader'])->get();

            // Admin/guru tidak perlu progress
        } else {
            // User biasa
            $userKelompok = \App\Models\UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $learning->id)
                ->first();

            if ($userKelompok) {
                $kelompok = \App\Models\Kelompok::with(['catatan.user'])
                    ->find($userKelompok->kelompok_id);

                // Ambil laporan kelompok
                $laporan = \App\Models\LaporanKelompok::where('kelompok_id', $userKelompok->kelompok_id)
                    ->with(['kelompok', 'uploader'])
                    ->get();
            }

            // === Hitung progress akumulatif ===

            // Tahap 1: identifikasi masalah tervalidasi
            $stage1 = \App\Models\LearningStage1Result::where('user_id', $user->id)
                ->whereHas('learningStage1', function ($q) use ($id) {
                    $q->where('learning_id', $id);
                })
                ->first();

            if ($stage1 && $stage1->is_validated) {
                $progress += $perStage;
            }

            // Tahap 2: sudah gabung kelompok
            $isJoined = \App\Models\UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $id)
                ->exists();

            if ($isJoined) {
                $progress += $perStage;
            }

            // Tahap 3: catatan tervalidasi
            $validatedCatatan = \App\Models\Catatan::where('learning_id', $id)
                ->where('user_id', $user->id)
                ->when($kelompok, function ($query) use ($kelompok) {
                    return $query->where('kelompok_id', $kelompok->id);
                })
                ->where('is_validated', true)
                ->exists();

            if ($validatedCatatan) {
                $progress += $perStage;
            }

            // Tahap 4: laporan kelompok tervalidasi
            $laporanValid = \App\Models\LaporanKelompok::where('kelompok_id', optional($kelompok)->id)
                ->where('learning_id', $id)
                ->where('is_validated', true)
                ->exists();

            if ($laporanValid) {
                $progress += $perStage;
            }

            // Tahap 5: refleksi sudah submit (tidak perlu validasi)
            $refleksi = \App\Models\RefleksiUser::where('learning_id', $id)
                ->where('user_id', $user->id)
                ->exists();

            if ($refleksi) {
                $progress += $perStage;
            }
        }

        return view('learning.stage4', compact('learning', 'kelompok', 'laporan', 'progress'));
    }


    public function showStage5($id)
    {
        $learning = Learning::findOrFail($id);

        // Ambil refleksi user login
        $existingRefleksi = RefleksiUser::where('user_id', auth()->id())
            ->where('learning_id', $learning->id)
            ->first();

        $semuaRefleksi = RefleksiUser::where('learning_id', $learning->id)
            ->with('user')
            ->get();

        // Ambil role user login
        $user = auth()->user();
        $userRole = $user->role;

        if (in_array($userRole, [0, 1])) {
            // Jika admin/guru, ambil semua kelompok
            $kelompok = Kelompok::where('learning_id', $learning->id)
                ->with('anggota.user')
                ->get();
        } else {
            // User biasa → kelompok dia saja
            $kelompok = Kelompok::where('learning_id', $learning->id)
                ->whereHas('anggota', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->with('anggota.user')
                ->get();
        }

        // Ambil evaluasi
        $evaluasi = Evaluasi::where('learning_id', $learning->id)
            ->whereIn('kelompok_id', $kelompok->pluck('id'))
            ->get()
            ->groupBy('kelompok_id');

        // ==============================
        // Hitung progress konsisten
        // ==============================
        $progress = 0;
        $totalStages = 5;
        $perStage = 100 / $totalStages;

        if ($userRole == 2) { // hanya user biasa dihitung
            // Tahap 1: identifikasi masalah tervalidasi
            $stage1 = \App\Models\LearningStage1Result::where('user_id', $user->id)
                ->whereHas('learningStage1', function ($q) use ($id) {
                    $q->where('learning_id', $id);
                })
                ->first();

            if ($stage1 && $stage1->is_validated) {
                $progress += $perStage;
            }

            // Tahap 2: sudah gabung kelompok
            $isJoined = \App\Models\UserKelompokLearning::where('user_id', $user->id)
                ->where('learning_id', $id)
                ->exists();

            if ($isJoined) {
                $progress += $perStage;
            }

            // Tahap 3: catatan tervalidasi
            $kelompokUser = $user->kelompokBelajar()->wherePivot('learning_id', $id)->first();
            $validatedCatatan = \App\Models\Catatan::where('learning_id', $id)
                ->where('user_id', $user->id)
                ->when($kelompokUser, function ($query) use ($kelompokUser) {
                    return $query->where('kelompok_id', $kelompokUser->id);
                })
                ->where('is_validated', true)
                ->exists();

            if ($validatedCatatan) {
                $progress += $perStage;
            }

            // Tahap 4: laporan kelompok tervalidasi
            $laporanValid = \App\Models\LaporanKelompok::where('kelompok_id', optional($kelompokUser)->id)
                ->where('learning_id', $id)
                ->where('is_validated', true)
                ->exists();

            if ($laporanValid) {
                $progress += $perStage;
            }

            // Tahap 5: refleksi (cukup submit)
            if ($existingRefleksi) {
                $progress += $perStage;
            }
        }

        return view('learning.stage5', compact(
            'learning',
            'existingRefleksi',
            'semuaRefleksi',
            'kelompok',
            'evaluasi',
            'progress'
        ));
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
