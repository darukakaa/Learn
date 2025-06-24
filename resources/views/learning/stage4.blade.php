<x-app-layout>
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
        <style>
            /* Sidebar dan responsive style tetap sama */
            .sidebar {
                width: 4rem;
                transition: width 0.3s ease;
                overflow-x: hidden;
                height: 100vh;
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
                    width: 100%;
                    height: auto;
                    display: flex;
                    overflow-x: auto;
                    white-space: nowrap;
                }

                .sidebar-link {
                    flex-shrink: 0;
                    display: inline-flex !important;
                    justify-content: center !important;
                    width: auto !important;
                }

                .sidebar-link span {
                    display: none !important;
                }
            }
        </style>

        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
                integrity="sha512-papmHCE9W8Me6iXKgp8n+HF8rhITxu6mA49wA2Yp3RxReD8BjOXQqePh1vN5R1+DoCdPQU09UugV1i5lFGY4Rw=="
                crossorigin="anonymous" referrerpolicy="no-referrer" />
        </head>

        <!-- Container utama full height, flex column -->
        <div class="min-h-screen flex flex-col bg-customGrayLight">
            <!-- Bagian isi utama (sidebar + content) flex row dan flexible height -->
            <div class="flex flex-1 flex-col md:flex-row">
                <!-- Sidebar -->
                <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2">
                    <!-- link sidebar seperti sebelumnya -->
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fa-solid fa-house w-6 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('materi.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-book w-6 text-center"></i>
                        <span>Materi</span>
                    </a>
                    <a href="{{ route('learning.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                        <span>Learning</span>
                    </a>
                    <a href="{{ route('kuis-tugas.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-tasks w-6 text-center"></i>
                        <span>Kuis/Tugas</span>
                    </a>
                    <a href="{{ route('data-siswa') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span>Data Siswa</span>
                    </a>
                    <a href="{{ route('modul.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Modul</span>
                    </a>
                </div>
                <!-- Main Content -->
                <div class="py-12 flex-1">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <!-- Learning Title and Stage Info -->
                        <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                            <div class="text-center">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4 text-2xl font-semibold">Tahap 4 Pengembangan dan Penyajian</p>
                                <div class="flex justify-center mt-3 space-x-2">
                                    <a href="{{ route('learning.index') }}"
                                        class="btn btn-secondary inline-block px-3 py-1 text-sm">Kembali
                                        ke Daftar
                                        Learning</a>
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
                                    <a href="{{ route('learning.stage5', ['id' => $learning->id]) }}"
                                        class="btn btn-primary inline-block px-3 py-1 text-sm">
                                        Lanjut ke Tahap 5
                                    </a>
                                    <a href="{{ route('learning.activity', ['learningId' => $learning->id]) }}"
                                        class="btn btn-primary inline-block px-3 py-1 text-sm">
                                        Aktivitas Siswa
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-customold shadow-sm sm:rounded-lg mb-6">
                            @if (Auth::user()->role === 0 || Auth::user()->role === 1)
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                                    @push('scripts')
                                        <link rel="stylesheet"
                                            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
                                    @endpush


                                    <div class="bg-white shadow-sm sm:rounded-lg p-4">
                                        <h2 class="text-xl font-semibold mb-4">Laporan Kelompok</h2>
                                        <table class="table-auto w-full border">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="border px-4 py-2">Kelompok</th>
                                                    <th class="border px-4 py-2">Diupload Oleh</th>
                                                    <th class="border px-4 py-2">File</th>
                                                    <th class="border px-4 py-2">Tanggal Upload</th>
                                                    <th class="border px-4 py-2">Nilai</th>
                                                    <th class="border px-4 py-2">Kriteria</th>
                                                    <th class="border px-4 py-2">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($laporan as $item)
                                                    <tr>
                                                        <td class="border px-4 py-2">
                                                            {{ $item->kelompok->nama_kelompok ?? '-' }}</td>
                                                        <td class="border px-4 py-2">{{ $item->user->name ?? '-' }}
                                                        </td>

                                                        <!-- ✅ Tombol lihat file dalam kolom -->
                                                        <td class="border px-4 py-2 text-center">
                                                            <button
                                                                onclick="document.getElementById('viewModal-{{ $item->id }}').classList.remove('hidden')"
                                                                class="text-blue-600 hover:text-blue-800">
                                                                <i class="fa-solid fa-file fa-lg"></i> Lihat
                                                            </button>
                                                        </td>

                                                        <td class="border px-4 py-2">
                                                            {{ $item->created_at->format('d M Y') }}</td>
                                                        <td class="border px-4 py-2">{{ $item->nilai ?? '-' }}</td>
                                                        <td class="border px-4 py-2">{{ $item->kriteria ?? '-' }}</td>
                                                        <td class="border px-4 py-2 space-y-2">
                                                            <!-- Validasi -->
                                                            <form action="{{ route('laporan.validasi', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="btn {{ $item->is_validated ? 'btn-danger' : 'btn-primary' }}">
                                                                    {{ $item->is_validated ? 'Unvalidasi' : 'Validasi' }}
                                                                </button>
                                                            </form>

                                                            <!-- Tombol nilai -->
                                                            <button
                                                                onclick="openModal({{ $item->id }}, {{ $item->nilai ?? 'null' }})"
                                                                class="btn btn-secondary w-full">
                                                                Nilai
                                                            </button>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal View File -->
                                                    <div id="viewModal-{{ $item->id }}"
                                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                                                        <div
                                                            class="bg-white rounded-lg shadow-lg w-full max-w-4xl h-4/5 flex flex-col relative overflow-hidden">

                                                            <!-- Header -->
                                                            <div class="flex justify-between items-center p-4 border-b">
                                                                <h2 class="text-lg font-semibold">Preview Laporan</h2>
                                                                <button
                                                                    onclick="document.getElementById('viewModal-{{ $item->id }}').classList.add('hidden')"
                                                                    class="text-gray-500 hover:text-red-600 text-xl font-bold">&times;</button>
                                                            </div>

                                                            <!-- Konten Scrollable -->
                                                            <div class="flex-grow overflow-y-auto p-4">
                                                                <iframe
                                                                    src="{{ asset('storage/' . $item->file_path) }}"
                                                                    class="w-full h-full border rounded"
                                                                    frameborder="0"></iframe>

                                                            </div>


                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                            <!-- Modal -->
                                            <div id="modal-nilai"
                                                class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden justify-center items-center">
                                                <div class="bg-white p-6 rounded shadow-md w-96">
                                                    <h2 class="text-lg font-bold mb-4">Beri Nilai</h2>
                                                    <form id="form-nilai" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="laporan_id" id="laporan_id">
                                                        <label for="nilai" class="block mb-2">Nilai (0 -
                                                            100):</label>
                                                        <input type="number" min="0" max="100"
                                                            id="nilai" name="nilai"
                                                            class="w-full border px-3 py-2 rounded mb-4" required>
                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" onclick="closeModal()"
                                                                class="btn btn-danger">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <script>
                                                function openModal(id, nilai = '') {
                                                    document.getElementById('modal-nilai').classList.remove('hidden');
                                                    document.getElementById('laporan_id').value = id;
                                                    document.getElementById('nilai').value = nilai ?? '';
                                                    document.getElementById('form-nilai').action = '/laporan/' + id + '/nilai';
                                                }

                                                function closeModal() {
                                                    document.getElementById('modal-nilai').classList.add('hidden');
                                                }
                                            </script>
                                        </table>


                                    </div>
                                </div>

                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
    @endif
    {{-- user --}}
    @if (auth()->user()->role == '2')
        <style>
            /* Sidebar dan responsive style tetap sama */
            .sidebar {
                width: 4rem;
                transition: width 0.3s ease;
                overflow-x: hidden;
                height: 100vh;
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
                    width: 100%;
                    height: auto;
                    display: flex;
                    overflow-x: auto;
                    white-space: nowrap;
                }

                .sidebar-link {
                    flex-shrink: 0;
                    display: inline-flex !important;
                    justify-content: center !important;
                    width: auto !important;
                }

                .sidebar-link span {
                    display: none !important;
                }
            }
        </style>

        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
                integrity="sha512-papmHCE9W8Me6iXKgp8n+HF8rhITxu6mA49wA2Yp3RxReD8BjOXQqePh1vN5R1+DoCdPQU09UugV1i5lFGY4Rw=="
                crossorigin="anonymous" referrerpolicy="no-referrer" />
        </head>

        <!-- Container utama full height, flex column -->
        <div class="min-h-screen flex flex-col bg-customGrayLight">
            <!-- Bagian isi utama (sidebar + content) flex row dan flexible height -->
            <div class="flex flex-1 flex-col md:flex-row">
                <!-- Sidebar -->
                <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2">
                    <!-- link sidebar seperti sebelumnya -->
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fa-solid fa-house w-6 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('materi.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-book w-6 text-center"></i>
                        <span>Materi</span>
                    </a>
                    <a href="{{ route('learning.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                        <span>Learning</span>
                    </a>
                    <a href="{{ route('kuis-tugas.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-tasks w-6 text-center"></i>
                        <span>Kuis/Tugas</span>
                    </a>
                    <a href="{{ route('modul.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Modul</span>
                    </a>
                </div>
                <!-- Main Content -->
                <div class="py-12 flex-1">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <!-- Learning Title and Stage Info -->
                        <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                            <div class="text-center">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4 text-2xl font-semibold">Tahap 4 Pengembangan dan Penyajian</p>
                                <!-- Navigation Buttons -->
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 bg-customold shadow-sm rounded-lg border-b border-gray-200">
                                @if ($kelompok)
                                    <h3 class="text-lg font-semibold mb-4">Catatan Anggota Kelompok</h3>

                                    <table class="min-w-full bg-white border border-gray-300">
                                        <thead class="bg-gray-100 text-left">
                                            <tr>
                                                <th class="px-4 py-2 border">No</th>
                                                <th class="px-4 py-2 border">Nama Anggota</th>
                                                <th class="px-4 py-2 border">Isi Catatan</th>
                                                <th class="px-4 py-2 border">File</th>
                                                <th class="px-4 py-2 border">Status Validasi</th>
                                                <th class="px-4 py-2 border">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($kelompok->catatan as $index => $catatan)
                                                <tr>
                                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                                    <td class="px-4 py-2 border">{{ $catatan->user->name }}</td>

                                                    {{-- Isi Catatan --}}
                                                    <td class="px-4 py-2 border">
                                                        @if ($catatan->is_validated)
                                                            {{ $catatan->isi_catatan }}
                                                        @else
                                                            <span class="text-gray-400 italic">Belum tervalidasi</span>
                                                        @endif
                                                    </td>

                                                    {{-- File --}}
                                                    <td class="px-4 py-2 border">
                                                        @if ($catatan->is_validated && $catatan->file_catatan)
                                                            <a href="{{ asset('storage/' . $catatan->file_catatan) }}"
                                                                download class="text-blue-600 underline">Download
                                                                File</a>
                                                        @else
                                                            <span class="text-gray-400 italic">-</span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Validasi --}}
                                                    <td class="px-4 py-2 border">
                                                        @if ($catatan->is_validated)
                                                            <span
                                                                class="text-green-600 font-semibold">Tervalidasi</span>
                                                        @else
                                                            <span class="text-red-600">Belum Valid</span>
                                                        @endif
                                                    </td>

                                                    <td class="px-4 py-2 border">
                                                        {{ $catatan->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-2 text-gray-500">Belum
                                                        ada
                                                        catatan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-gray-600">Kamu belum tergabung dalam kelompok untuk learning ini.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 bg-customold shadow-sm rounded-lg border-b border-gray-200">
                                @if ($kelompok)
                                    @php
                                        $allCatatanValidated =
                                            $kelompok->catatan->count() > 0 &&
                                            $kelompok->catatan->every(fn($catatan) => $catatan->is_validated);
                                    @endphp

                                    @if ($allCatatanValidated)
                                        @if ($laporan->isEmpty())
                                            <!-- Tombol Upload -->
                                            <button
                                                onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                                                class="btn btn-primary rounded-full">
                                                Upload Laporan Kelompok
                                            </button>
                                        @else
                                            <p>Perwakilan kelompok Anda sudah upload laporan kelompok.</p>
                                        @endif
                                    @else
                                        <p class="text-red-600 font-semibold">Semua catatan anggota kelompok harus
                                            tervalidasi terlebih dahulu sebelum mengupload laporan kelompok.</p>
                                    @endif
                                @else
                                    <p class="text-gray-600">Kamu belum tergabung dalam kelompok untuk learning ini.
                                    </p>
                                @endif



                                <!-- Modal Upload -->
                                <div id="uploadModal"
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                                    <div class="bg-white p-6 rounded shadow w-full max-w-md relative">
                                        <!-- Tombol tutup (X) -->


                                        <h2 class="text-lg font-semibold mb-4">Upload Laporan Kelompok</h2>
                                        <form action="{{ route('laporan_kelompok.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file_laporan" required>
                                            <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">
                                            <button type="submit"
                                                class="btn btn-primary rounded-full">Upload</button>
                                            <button type="button" class="btn btn-secondary"
                                                onclick="document.getElementById('uploadModal').classList.add('hidden')"
                                                aria-label="Close modal">Batal</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                                    <div class="bg-white shadow-sm sm:rounded-lg p-4">
                                        <h2 class="text-xl font-semibold mb-4">Laporan Kelompok Anda</h2>
                                        <table class="table-auto w-full border">
                                            <thead class="bg-gray-100">
                                                <tr>

                                                    <th class="border px-4 py-2">Diupload Oleh</th>
                                                    <th class="border px-4 py-2">File</th>
                                                    <th class="border px-4 py-2">Tanggal Upload</th>
                                                    <th class="border px-4 py-2">Status Validasi</th>
                                                    <th class="border px-4 py-2">Nilai</th>
                                                    <th class="border px-4 py-2">Kriteria</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($laporan as $item)
                                                    <tr>

                                                        <td class="border px-4 py-2">{{ $item->user->name ?? '-' }}
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                class="text-blue-600 underline" target="_blank">
                                                                Lihat File
                                                            </a>
                                                            <br>
                                                            @if (!$item->is_validated)
                                                                <button
                                                                    onclick="document.getElementById('editModal-{{ $item->id }}').classList.remove('hidden')"
                                                                    class="btn btn-primary">Edit</button>
                                                            @endif
                                                        </td>

                                                        <td class="border px-4 py-2">
                                                            {{ $item->created_at->format('d M Y') }}
                                                        </td>
                                                        <td class="border px-4 py-2">
                                                            {{ $item->is_validated ? 'Tervalidasi' : 'Belum Divalidasi' }}
                                                        </td>
                                                        <td class="border px-4 py-2">{{ $item->nilai ?? '-' }}</td>
                                                        <td class="border px-4 py-2">{{ $item->kriteria ?? '-' }}</td>
                                                    </tr>
                                                    <!-- Modal Edit File -->
                                                    <div id="editModal-{{ $item->id }}"
                                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                                                        <div
                                                            class="bg-white p-6 rounded shadow w-full max-w-md relative">
                                                            <h2 class="text-lg font-semibold mb-4">Edit File Laporan
                                                            </h2>
                                                            <form
                                                                action="{{ route('laporan_kelompok.update', $item->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="file" name="file_laporan" required>
                                                                <button type="submit"
                                                                    class="btn btn-primary mt-3">Update</button>
                                                                <button type="button" class="btn btn-secondary mt-3"
                                                                    onclick="document.getElementById('editModal-{{ $item->id }}').classList.add('hidden')">
                                                                    Batal
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if ($laporan->contains('is_validated', true))
                                    <a href="{{ route('learning.stage5', ['id' => $learning->id]) }}"
                                        class="btn btn-primary rounded-full">
                                        Lanjut ke Tahap 5
                                    </a>
                                @endif
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
