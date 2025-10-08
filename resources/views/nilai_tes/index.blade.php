<x-app-layout>

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
            padding-top: 0rem;
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
        <div class="main-content py-12 flex-1">
            <div class="flex-1 p-6">
                <div class="bg-white p-6 rounded shadow w-full">
                    <a href="{{ route('tes_soal.index') }}" class="btn btn-secondary mb-4 inline-block">← Kembali ke
                        Daftar Tes</a>

                    <h1 class="text-2xl font-bold mb-4">Nilai Tes Anda</h1>

                    <p class="text-lg">Total Nilai: <strong>{{ $totalNilai }}</strong></p>

                    <h2 class="mt-6 font-semibold">Detail Jawaban:</h2>

                    <div class="overflow-y-auto max-h-[500px] mt-2 pr-2">
                        <ul class="list-disc list-inside space-y-4">
                            @foreach ($soals as $soal)
                                @php
                                    $jawaban = $jawabanUser->firstWhere('soal_id', $soal->id);
                                @endphp
                                <li class="bg-gray-50 p-4 rounded shadow">
                                    <p><strong>Pertanyaan:</strong> {{ $soal->pertanyaan }}</p>

                                    {{-- Tampilkan gambar jika ada --}}
                                    @if ($soal->gambar)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $soal->gambar) }}" alt="Gambar Soal"
                                                class="max-w-xs rounded border">
                                        </div>
                                    @endif

                                    @foreach (['A', 'B', 'C', 'D', 'E'] as $opt)
                                        <p class="ml-4">
                                            <strong>{{ $opt }}.</strong>
                                            {{ $soal->{'pilihan_' . strtolower($opt)} }}
                                            @if ($soal->jawaban_benar === $opt)
                                                <span class="text-green-600 font-semibold">✔ Jawaban Benar</span>
                                            @endif
                                            @if ($jawaban && $jawaban->pilihan_jawaban === $opt)
                                                <span class="text-blue-600 font-semibold">← Jawaban Anda</span>
                                            @endif
                                        </p>
                                    @endforeach

                                    @if (!$jawaban)
                                        <p class="text-yellow-600 font-semibold mt-2">⚠️ Belum dijawab oleh Anda</p>
                                    @endif

                                    <p class="mt-2">
                                        <strong>Bobot Nilai:</strong>
                                        @if ($jawaban && $jawaban->pilihan_jawaban === $soal->jawaban_benar)
                                            <span class="text-green-600 font-bold">{{ $soal->bobot_nilai }} ✅</span>
                                        @else
                                            <span class="text-red-600 font-bold">0 ❌</span>
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>
        </div>
        <!-- Footer: di luar container flex-row, full width -->
        <footer class="bg-customBlack text-center py-2 px-4 text-sm">
            <p class="text-customGrayLight">&copy; Learnify 2024</p>
        </footer>
</x-app-layout>
