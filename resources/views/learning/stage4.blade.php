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
                        @if (Auth::user()->role === 0 || Auth::user()->role === 1)
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                                    <h2 class="text-xl font-semibold mb-4">Laporan Kelompok</h2>
                                    <table class="table-auto w-full border">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="border px-4 py-2">Kelompok</th>
                                                <th class="border px-4 py-2">Diupload Oleh</th>
                                                <th class="border px-4 py-2">File</th>
                                                <th class="border px-4 py-2">Status Validasi</th>
                                                <th class="border px-4 py-2">Tanggal Upload</th>
                                                <th class="border px-4 py-2">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan as $item)
                                                <tr>
                                                    <td class="border px-4 py-2">
                                                        {{ $item->kelompok->nama_kelompok ?? '-' }}</td>
                                                    <td class="border px-4 py-2">{{ $item->user->name ?? '-' }}</td>
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <a href="{{ asset('storage/' . $item->file_path) }}"
                                                            class="text-blue-600 underline" target="_blank">Lihat
                                                            File</a>
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        {{ $item->is_validated ? 'Tervalidasi' : 'Belum Divalidasi' }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        {{ $item->created_at->format('d M Y H:i') }}</td>
                                                    <td class="border px-4 py-2">
                                                        <form action="{{ route('laporan.validasi', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                class="btn {{ $item->is_validated ? 'btn-danger' : 'btn-primary' }}">
                                                                {{ $item->is_validated ? 'Unvalidasi' : 'Validasi' }}
                                                            </button>


                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif





                        <a href="{{ route('learning.stage5', ['id' => $learning->id]) }}" class="btn btn-primary">
                            Lanjut ke Tahap 5
                        </a>
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
                    <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
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
                                                <th class="border px-4 py-2">Status Validasi</th>
                                                <th class="border px-4 py-2">Tanggal Upload</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($laporan as $item)
                                                <tr>

                                                    <td class="border px-4 py-2">{{ $item->user->name ?? '-' }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <a href="{{ asset('storage/' . $item->file_path) }}"
                                                            class="text-blue-600 underline" target="_blank">Lihat
                                                            File</a>
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        {{ $item->is_validated ? 'Tervalidasi' : 'Belum Divalidasi' }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        {{ $item->created_at->format('d M Y H:i') }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
    @endif
</x-app-layout>
