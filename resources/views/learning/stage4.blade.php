<x-app-layout>
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
                <nav class="flex-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                    <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                    <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                    <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                        <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                    @endif
                </nav>
            </div>
            <!-- Main Content -->
            <div class="py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 4 Pengembangan dan Penyajian</p>

                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p class="mt-4">STAGE</p>
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
                            <a href="{{ route('learning.stage5', ['id' => $learning->id]) }}"
                                class="btn btn-primary  mt-4 inline-block ml-2">
                                Lanjut ke Tahap 5
                            </a>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
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
                                                    <td class="border px-4 py-2">{{ $item->user->name ?? '-' }}</td>

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
                                                            <iframe src="{{ asset('storage/' . $item->file_path) }}"
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
                                                    <label for="nilai" class="block mb-2">Nilai (0 - 100):</label>
                                                    <input type="number" min="0" max="100" id="nilai"
                                                        name="nilai" class="w-full border px-3 py-2 rounded mb-4"
                                                        required>
                                                    <div class="flex justify-end gap-2">
                                                        <button type="button" onclick="closeModal()"
                                                            class="btn btn-danger">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
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
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
                <nav class="flex-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                    <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                    <a href="{{ route('kuis-tugas.index') }}"
                        class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                    <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 4 Pengembangan dan Penyajian</p>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
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
                                                            download class="text-blue-600 underline">Download File</a>
                                                    @else
                                                        <span class="text-gray-400 italic">-</span>
                                                    @endif
                                                </td>

                                                {{-- Status Validasi --}}
                                                <td class="px-4 py-2 border">
                                                    @if ($catatan->is_validated)
                                                        <span class="text-green-600 font-semibold">Tervalidasi</span>
                                                    @else
                                                        <span class="text-red-600">Belum Valid</span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-2 border">
                                                    {{ $catatan->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-2 text-gray-500">Belum ada
                                                    catatan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-600">Kamu belum tergabung dalam kelompok untuk learning ini.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
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
                                <p class="text-gray-600">Kamu belum tergabung dalam kelompok untuk learning ini.</p>
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
                                        <button type="submit" class="btn btn-primary rounded-full">Upload</button>
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
                                                    <div class="bg-white p-6 rounded shadow w-full max-w-md relative">
                                                        <h2 class="text-lg font-semibold mb-4">Edit File Laporan</h2>
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
</x-app-layout>
