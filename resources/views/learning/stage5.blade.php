<x-app-layout>
    {{-- Sidebar dan Konten Utama untuk Admin dan Guru --}}
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')

        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
                crossorigin="anonymous" referrerpolicy="no-referrer" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </head>

        <style>
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 4rem;
                transition: width 0.3s ease;
                overflow-x: hidden;
                z-index: 50;
                background-color: #ffffff;
            }

            .sidebar:hover {
                width: 14rem;
            }

            .sidebar-link span {
                opacity: 0;
                transition: opacity 0.3s ease;
                white-space: nowrap;
            }

            .sidebar:hover .sidebar-link span {
                opacity: 1;
                margin-left: 0.5rem;
            }

            @media (max-width: 767px) {
                .sidebar {
                    position: static;
                    width: 100%;
                    height: auto;
                    display: flex;
                    flex-direction: row;
                    overflow-x: auto;
                    white-space: nowrap;
                }

                .sidebar-link {
                    flex-shrink: 0;
                    justify-content: center !important;
                    width: auto !important;
                }

                .sidebar-link span {
                    display: none !important;
                }
            }

            .main-content {
                margin-left: 4rem;
                transition: margin-left 0.3s ease;
                padding-top: 4rem;
                z-index: 10;
                min-height: calc(100vh - 40px);
            }

            .sidebar:hover~.main-content {
                margin-left: 14rem;
            }

            @media (max-width: 767px) {
                .main-content {
                    margin-left: 0 !important;
                    padding-top: 0 !important;
                }
            }

            footer {
                width: 100%;
            }

            #modalPenugasan {
                z-index: 9999;
            }
        </style>

        <div class="min-h-screen bg-customGrayLight">
            <!-- Sidebar -->
            <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2 mt-16">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fa-solid fa-house w-6 text-center"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('materiv2.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-book-open w-6 text-center"></i><span>Materi</span>
                </a>
                <a href="{{ route('learning.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-chalkboard-teacher w-6 text-center"></i><span>Learning</span>
                </a>
                <a href="{{ route('tes_soal.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-tasks w-6 text-center"></i><span>Tes Soal</span>
                </a>
                <a href="{{ route('kuis-tugas.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-folder w-6 text-center"></i><span>Tugas</span>
                </a>
                @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                    <a href="{{ route('data-siswa') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-users w-6 text-center"></i><span>Data Siswa</span>
                    </a>
                @endif
            </div>

            {{-- Konten Utama --}}
            <div class="main-content py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Title -->
                    <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4 text-2xl font-semibold">Tahap 5 Pengevaluasian masalah dan Penyimpulan
                            </p>
                            <div class="flex justify-center mt-3 space-x-2">
                                <a href="{{ route('learning.index') }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Daftar Learning
                                </a>
                                <a href="{{ route('learning.show', ['learning' => $learning->id]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 1
                                </a>
                                <a href="{{ route('learning.stage', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 2
                                </a>
                                <a href="{{ route('learning.stage3', ['learningId' => $learning->id]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 3
                                </a>
                                <a href="{{ route('learning.stage4', ['id' => $learning->id]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 4
                                </a>
                                <a href="{{ route('learning.activity', ['learningId' => $learning->id]) }}"
                                    class="btn btn-primary inline-block px-3 py-1 text-sm">
                                    Aktivitas Siswa
                                </a>
                                <button
                                    onclick="confirmSelesaikanLearning('{{ $learning->id }}', '{{ $learning->nama_learning }}')"
                                    class="btn btn-danger inline-block px-3 py-1 text-sm">
                                    Selesaikan Learning
                                </button>
                                @if (session('learning_completed'))
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        function confirmSelesaikanLearning(id, namaLearning) {
                                            Swal.fire({
                                                title: 'Apakah Anda yakin?',
                                                text: "Learning '" + namaLearning + "' akan diselesaikan.",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'Ya, Selesaikan!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Redirect ke route penyelesaian
                                                    window.location.href = `/learnings/${id}/selesaikan`;
                                                }
                                            });
                                        }
                                    </script>
                                @endif

                                <!-- SweetAlert -->
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                            </div>
                        </div>
                        <script>
                            function confirmSelesaikanLearning(learningId, learningName) {
                                Swal.fire({
                                    title: 'Apakah Anda yakin?',
                                    text: `Anda yakin ingin menyelesaikan learning "${learningName}"?`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Selesaikan!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = `/learning/${learningId}/selesaikan`;
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
                <!-- Refleksi -->
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-customold shadow-sm sm:rounded-lg mb-6">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                            <div class="bg-customold shadow-sm sm:rounded-lg p-4">
                                <p class="font-semibold text-lg">RELEKSI</p>
                                @if ($semuaRefleksi->isEmpty())
                                    <p class="text-black-500 mt-2">Belum ada refleksi yang ditambahkan.</p>
                                @else
                                    <table class="w-full mt-4 table-auto border border-collapse">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="border p-2 text-left">Nama</th>
                                                <th class="border p-2 text-left">Refleksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($semuaRefleksi as $index => $refleksi)
                                                <tr>
                                                    <td class="border p-2">{{ $refleksi->user->name }}</td>
                                                    <td class="border p-2">
                                                        <button data-modal-target="modalRefleksi{{ $index }}"
                                                            data-modal-toggle="modalRefleksi{{ $index }}"
                                                            class="btn btn-primary">Lihat Refleksi</button>

                                                        <!-- Modal Refleksi -->
                                                        <div id="modalRefleksi{{ $index }}"
                                                            class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex justify-center items-center">
                                                            <div
                                                                class="bg-white w-full max-w-xl rounded shadow-lg p-6 relative">
                                                                <h2 class="text-xl font-bold mb-4">Refleksi dari
                                                                    {{ $refleksi->user->name }}</h2>
                                                                <p><strong>Apa yang telah dipelajari:</strong>
                                                                    {{ $refleksi->apa_yang_dipelahari }}</p>
                                                                <p><strong>Kesulitan:</strong>
                                                                    {{ $refleksi->kesulitan }}
                                                                </p>
                                                                <p><strong>Kontribusi:</strong>
                                                                    {{ $refleksi->kontribusi }}
                                                                </p>
                                                                <p><strong>Saran:</strong> {{ $refleksi->saran }}
                                                                </p>
                                                                <p class="text-sm text-gray-500 mt-4">Ditambahkan
                                                                    pada
                                                                    {{ $refleksi->created_at->format('d M Y H:i') }}
                                                                </p>

                                                                <button
                                                                    onclick="document.getElementById('modalRefleksi{{ $index }}').classList.add('hidden')"
                                                                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">✕</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Evaluasi -->
                @php
                    $kelompokDievaluasi = \App\Models\Evaluasi::where('learning_id', $learning->id)
                        ->pluck('kelompok_id')
                        ->toArray();
                @endphp
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-customold shadow-sm sm:rounded-lg mb-6">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                            <div class="bg-customold shadow-sm sm:rounded-lg p-4">
                                <p class="font-semibold text-lg">EVALUASI</p>
                            </div>

                            @if (session('success'))
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: '{{ session('success') }}',
                                        confirmButtonText: 'Tutup'
                                    });
                                </script>
                            @endif


                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                                @foreach ($kelompok as $k)
                                    <div
                                        class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                        <h2 class="text-lg font-semibold">{{ $k->nama_kelompok }}</h2>
                                        <p class="text-sm mt-2">Jumlah Kelompok: {{ $k->jumlah_kelompok }}</p>
                                        <p class="text-sm">Anggota: {{ $k->anggota->count() }} /
                                            {{ $k->jumlah_kelompok }}</p>

                                        <p class="text-sm mt-2">Nama Anggota:</p>
                                        <ul class="list-disc ml-5 mb-2">
                                            @forelse ($k->anggota as $anggota)
                                                <li>{{ $anggota->user->name }}</li>
                                            @empty
                                                <li>Belum ada anggota.</li>
                                            @endforelse
                                        </ul>

                                        @unless (in_array($k->id, $kelompokDievaluasi))
                                            <button data-modal-target="modal-evaluasi-{{ $k->id }}"
                                                data-modal-toggle="modal-evaluasi-{{ $k->id }}"
                                                class="btn btn-primary">Evaluasi</button>
                                        @endunless
                                    </div>

                                    <!-- Modal Evaluasi -->
                                    <div id="modal-evaluasi-{{ $k->id }}"
                                        class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
                                        <div class="bg-white rounded-lg shadow w-full max-w-md">
                                            <div class="p-4 border-b">
                                                <h3 class="text-lg font-semibold">Evaluasi untuk kelompok
                                                    {{ $k->nama_kelompok }}
                                                </h3>
                                            </div>
                                            <form action="{{ route('evaluasi.store') }}" method="POST" class="p-4">
                                                @csrf
                                                <input type="hidden" name="kelompok_id" value="{{ $k->id }}">
                                                <input type="hidden" name="learning_id" value="{{ $learning->id }}">

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium">Deskripsi
                                                        Evaluasi</label>
                                                    <textarea name="deskripsi" rows="4" class="w-full border rounded p-2" required></textarea>
                                                </div>

                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        data-modal-hide="modal-evaluasi-{{ $k->id }}"
                                                        class="btn btn-secondary">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <script>
                        document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const target = btn.getAttribute('data-modal-target');
                                document.getElementById(target)?.classList.remove('hidden');
                            });
                        });

                        document.querySelectorAll('[data-modal-hide]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const target = btn.getAttribute('data-modal-hide');
                                document.getElementById(target)?.classList.add('hidden');
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    @endif

    {{-- Sidebar dan Konten untuk User --}}
    @if (auth()->user()->role == '2')

        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
                crossorigin="anonymous" referrerpolicy="no-referrer" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </head>

        <style>
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 4rem;
                transition: width 0.3s ease;
                overflow-x: hidden;
                z-index: 50;
                background-color: #ffffff;
            }

            .sidebar:hover {
                width: 14rem;
            }

            .sidebar-link span {
                opacity: 0;
                transition: opacity 0.3s ease;
                white-space: nowrap;
            }

            .sidebar:hover .sidebar-link span {
                opacity: 1;
                margin-left: 0.5rem;
            }

            @media (max-width: 767px) {
                .sidebar {
                    position: static;
                    width: 100%;
                    height: auto;
                    display: flex;
                    flex-direction: row;
                    overflow-x: auto;
                    white-space: nowrap;
                }

                .sidebar-link {
                    flex-shrink: 0;
                    justify-content: center !important;
                    width: auto !important;
                }

                .sidebar-link span {
                    display: none !important;
                }
            }

            .main-content {
                margin-left: 4rem;
                transition: margin-left 0.3s ease;
                padding-top: 4rem;
                z-index: 10;
                min-height: calc(100vh - 40px);
            }

            .sidebar:hover~.main-content {
                margin-left: 14rem;
            }

            @media (max-width: 767px) {
                .main-content {
                    margin-left: 0 !important;
                    padding-top: 0 !important;
                }
            }

            footer {
                width: 100%;
            }

            #modalPenugasan {
                z-index: 9999;
            }
        </style>

        <div class="min-h-screen bg-customGrayLight">
            <!-- Sidebar -->
            <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2 mt-16">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fa-solid fa-house w-6 text-center"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('materiv2.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-folder w-6 text-center"></i><span>Materi</span>
                </a>
                <a href="{{ route('learning.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-chalkboard-teacher w-6 text-center"></i><span>Learning</span>
                </a>
                <a href="{{ route('tes_soal.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-tasks w-6 text-center"></i><span>Tes Soal</span>
                </a>
                <a href="{{ route('kuis-tugas.index') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-folder w-6 text-center"></i><span>Tugas</span>
                </a>
                @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                    <a href="{{ route('data-siswa') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-users w-6 text-center"></i><span>Data Siswa</span>
                    </a>
                @endif
            </div>

            {{-- Konten Utama --}}
            <div class="main-content py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4 text-2xl font-semibold">Tahap 5 Pengevaluasian masalah dan Penyimpulan
                            </p>
                            <div class="flex justify-center mt-3 space-x-2">
                                <a href="{{ route('learning.index') }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Daftar Learning
                                </a>
                                <a href="{{ route('learning.show', ['learning' => $learning->id]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 1
                                </a>
                                <a href="{{ route('learning.stage', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 2
                                </a>
                                <a href="{{ route('learning.stage3', ['learningId' => $learning->id]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 3
                                </a>
                                <a href="{{ route('learning.stage4', ['id' => $learning->id]) }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 4
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refleksi -->
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-customold shadow-sm sm:rounded-lg mb-6">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                            <div class="bg-customold shadow-sm sm:rounded-lg p-4">
                                <p class="font-semibold text-lg">RELEKSI</p>
                                @if (!$existingRefleksi)
                                    <form action="{{ route('refleksi.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="learning_id" value="{{ $learning->id }}">

                                        <div class="mb-4">
                                            <label>Apa yang telah dipelajari:</label>
                                            <textarea name="apa_yang_dipelahari" class="w-full border p-2" required></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label>Kesulitan yang dialami:</label>
                                            <textarea name="kesulitan" class="w-full border p-2" required></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label>Kontribusi pribadi:</label>
                                            <textarea name="kontribusi" class="w-full border p-2" required></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label>Saran untuk perbaikan:</label>
                                            <textarea name="saran" class="w-full border p-2" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Kirim Refleksi</button>
                                    </form>
                                @else
                                    <div class="p-4 bg-green-100 border border-green-400 rounded text-green-700">
                                        ✅ Anda telah menambahkan refleksi pada learning
                                        <strong>{{ $learning->name }}</strong>.
                                    </div>
                                @endif

                                @if (session('success'))
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sukses!',
                                            text: '{{ session('success') }}',
                                            confirmButtonText: 'Tutup'
                                        });
                                    </script>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-customold shadow-sm sm:rounded-lg mb-6">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                            <div class="bg-customold shadow-sm sm:rounded-lg p-4">
                                <p class="font-semibold text-lg">EVALUASI</p>
                            </div>
                            @php
                                $evaluasis = \App\Models\Evaluasi::where('learning_id', $learning->id)
                                    ->get()
                                    ->groupBy('kelompok_id');
                            @endphp

                            <div class="mt-4 space-y-8">
                                @foreach ($kelompok as $k)
                                    <h2>Nama Kelompok Anda: {{ $k->nama_kelompok }}</h2>

                                    @if (isset($evaluasi[$k->id]) && $evaluasi[$k->id]->count() > 0)
                                        @foreach ($evaluasi[$k->id] as $eval)
                                            <p>{{ $eval->deskripsi }}</p>
                                        @endforeach
                                    @else
                                        <p>Belum ada evaluasi.</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endif
    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
