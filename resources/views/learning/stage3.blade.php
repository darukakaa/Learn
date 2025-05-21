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
                            <p class="mt-4">Tahap 3 Pembimbingan Penyelidikan</p>
                        </div>
                    </div>
                </div>


                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">

                            <body>
                                <h1>Pembimbingan Siswa</h1>
                                {{-- Tombol Kembali --}}
                                <a href="{{ route('learning.stage', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                                    class="btn btn-secondary mt-4 inline-block ml-2">
                                    Kembali ke Daftar Kelompok
                                </a>
                            </body>


                            <table class="min-w-full bg-white border border-gray-300 mt-6">
                                <thead>
                                    <tr class="bg-gray-100 text-left">
                                        <th class="px-4 py-2 border">No</th>
                                        <th class="px-4 py-2 border">Nama</th>
                                        <th class="px-4 py-2 border">Kelompok</th>
                                        <th class="px-4 py-2 border">Isi Catatan</th>
                                        <th class="px-4 py-2 border">Bukti Code/File</th>
                                        <th class="px-4 py-2 border">Validasi</th> <!-- Kolom baru -->
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($catatanList as $index => $catatan)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border">{{ $catatan->user->name }}</td>
                                            <td class="px-4 py-2 border">{{ $catatan->kelompok->nama_kelompok }}</td>
                                            <td class="px-4 py-2 border">{{ $catatan->isi_catatan }}</td>
                                            <td class="px-4 py-2 border">
                                                @if ($catatan->file_catatan)
                                                    <a href="{{ asset('storage/' . $catatan->file_catatan) }}"
                                                        target="_blank" class="text-blue-500 underline">Lihat File</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">
                                                <form action="{{ route('catatan.toggleValidate', $catatan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $catatan->is_validated ? 'btn-danger' : 'btn-primary' }}">
                                                        {{ $catatan->is_validated ? 'Batalkan Validasi' : 'Validasi' }}
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('learning.stage4', ['id' => $learning->id]) }}" class="btn btn-primary">
                                Lanjut ke Tahap 4
                            </a>

                        </div>
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

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: '{{ session('success') }}',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        });
                    </script>
                @endif

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 3 Pembimbingan Penyelidikan</p>
                        </div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">

                            <body>
                                <h1>Compiler</h1>
                                <iframe src="https://trinket.io/embed/python3/9c6c5027a4" width="100%" height="300"
                                    frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
                            </body>
                        </div>
                    </div>
                </div>

                <!-- Kontainer -->
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-xl font-bold mb-4">Catatan</h1>

                            <!-- Tombol Tambahkan Catatan -->
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalCatatan"
                                class="btn btn-primary">
                                Tambahkan Catatan
                            </button>

                            <!-- Modal Form Tambah Catatan -->
                            <div class="modal fade" id="modalCatatan" tabindex="-1" aria-labelledby="modalCatatanLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('catatan.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalPenugasanLabel">Tambah Catatan</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                                <div class="mb-4">
                                                    <label for="isi_catatan" class="block font-medium mb-1">Isi
                                                        Catatan</label>
                                                    <textarea name="isi_catatan" id="isi_catatan" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="file_catatan" class="block font-medium mb-1">Upload
                                                        File
                                                        (Opsional)</label>
                                                    <input type="file" name="file_catatan" id="file_catatan"
                                                        class="w-full border rounded px-3 py-2" required>
                                                </div>
                                                <input type="hidden" name="learning_id"
                                                    value="{{ $learning->id ?? '' }}">
                                                <input type="hidden" name="kelompok_id"
                                                    value="{{ $kelompok->id ?? '' }}">
                                                <input type="hidden" name="user_id"
                                                    value="{{ auth()->user()->id }}">
                                            </div>
                                            <!-- Modal Footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Kirim</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                    </form>
                                </div>

                            </div>
                            <table class="min-w-full bg-white border border-gray-300 mt-6">
                                <thead>
                                    <tr class="bg-gray-100 text-left">
                                        <th class="px-4 py-2 border">No</th>
                                        <th class="px-4 py-2 border">Isi Catatan</th>
                                        <th class="px-4 py-2 border">Bukti Code/File</th>
                                        <th class="px-4 py-2 border">Aksi</th>
                                        <th class="px-4 py-2 border">Status Validasi</th> {{-- Kolom baru --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($catatanList as $index => $catatan)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border">{{ $catatan->isi_catatan }}</td>
                                            <td class="px-4 py-2 border">
                                                @if ($catatan->file_catatan)
                                                    <a href="{{ asset('storage/' . $catatan->file_catatan) }}"
                                                        target="_blank" class="text-blue-500 underline">Lihat File</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">
                                                @if (!$catatan->is_validated)
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $catatan->id }}">
                                                        Edit
                                                    </button>
                                                @else
                                                    <span class="text-gray-400 italic">Terkunci</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border">
                                                @if ($catatan->is_validated)
                                                    <span class="text-green-600 font-semibold">Tervalidasi</span>
                                                @else
                                                    <span class="text-red-600 font-semibold">Belum Validasi</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if (!$catatan->is_validated)
                                            <!-- Modal Edit Catatan -->
                                            <div class="modal fade" id="editModal{{ $catatan->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $catatan->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('catatan.update', $catatan->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $catatan->id }}">Edit
                                                                    Catatan
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-4">
                                                                    <label for="isi_catatan"
                                                                        class="block font-medium mb-1">Isi
                                                                        Catatan</label>
                                                                    <textarea name="isi_catatan" rows="4" class="w-full border rounded px-3 py-2" required>{{ $catatan->isi_catatan }}</textarea>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label for="file_catatan"
                                                                        class="block font-medium mb-1">Ganti File
                                                                        (Opsional)
                                                                    </label>
                                                                    <input type="file" name="file_catatan"
                                                                        class="w-full border rounded px-3 py-2">
                                                                    @if ($catatan->file_catatan)
                                                                        <small class="text-gray-500">File saat ini: <a
                                                                                href="{{ asset('storage/' . $catatan->file_catatan) }}"
                                                                                target="_blank"
                                                                                class="text-blue-500 underline">Lihat
                                                                                File</a></small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                            @php
                                $isValidated = $catatanList->where('is_validated', true)->count() > 0;
                            @endphp

                            @if (auth()->user()->role == 2 && $isValidated)
                                <a href="{{ route('learning.stage4', ['id' => $learning->id]) }}"
                                    class="bg-gray-500 text-white font-bold py-2 px-6 rounded-full hover:bg-gray-600 inline-block mt-4">
                                    Lanjut ke Tahap 4
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
</x-app-layout>
