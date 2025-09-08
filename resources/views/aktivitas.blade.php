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

        {{-- Konten Utama --}}
        <div class="main-content py-12 flex-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                    <div class="text-center">
                        <p class="mt-4 text-2xl font-semibold">AKTIVITAS SISWA PADA LEARNING
                            {{ $learning->name }}</p>
                        <div class="flex justify-center mt-3 space-x-2">
                            <a href="{{ route('learning.index') }}"
                                class="btn btn-secondary mt-4 inline-block ml-2">Kembali
                                ke Daftar
                                Learning</a>
                            <a href="{{ route('learning.show', ['learning' => $learning->id]) }}"
                                class="btn btn-secondary mt-4 inline-block ml-2">
                                Kembali ke Tahap 1
                            </a>
                            <a href="{{ route('learning.stage', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                                class="btn btn-secondary mt-4 inline-block ml-2">
                                Kembali ke Tahap 2
                            </a>
                            <a href="{{ route('learning.stage3', ['learningId' => $learning->id]) }}"
                                class="btn btn-secondary mt-4 inline-block ml-2">
                                Kembali ke Tahap 3
                            </a>
                            <a href="{{ route('learning.stage4', ['id' => $learning->id]) }}"
                                class="btn btn-secondary mt-4 inline-block ml-2">
                                Kembali ke Tahap 4
                            </a>
                            <a href="{{ route('learning.stage5', ['id' => $learning->id]) }}"
                                class="btn btn-secondary mt-4 inline-block ml-2">
                                Kembali ke Tahap 5
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Aktivitas Table -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                        @if ($aktivitas->isEmpty())
                            <p class="text-gray-600">Belum ada aktivitas siswa untuk learning ini.</p>
                        @else
                            @php
                                $tahapNames = [
                                    '1' => 'Identifikasi Masalah',
                                    '2' => 'Gabung Kelompok & Penugasan',
                                    '3' => 'Catatan',
                                    '4' => 'Laporan Kelompok',
                                    '5' => 'Refleksi',
                                ];
                            @endphp
                            <table class="min-w-full border border-gray-300 rounded-md">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 border-b text-left">No</th>
                                        <th class="px-4 py-2 border-b text-left">Nama Siswa</th>
                                        <th class="px-4 py-2 border-b text-left">Tahap</th> <!-- kolom baru -->
                                        <th class="px-4 py-2 border-b text-left">Aktivitas</th>
                                        <th class="px-4 py-2 border-b text-left">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aktivitas as $index => $item)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                            <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border-b">
                                                {{ $item->user->name ?? 'User tidak ditemukan' }}</td>
                                            <td class="px-4 py-2 border-b">{{ $item->tahap }}</td>
                                            <!-- tampilkan tahap -->
                                            <td class="px-4 py-2 border-b">{{ $item->jenis_aktivitas }}</td>
                                            <td class="px-4 py-2 border-b">
                                                {{ \Carbon\Carbon::parse($item->waktu_aktivitas)->format('d M Y H:i') }}
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
    </div>
    </div>
    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
