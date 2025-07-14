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
                    <!-- link sidebar -->
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fa-solid fa-house w-6 text-center"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('materiv2.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Materi</span>
                    </a>
                    <a href="{{ route('learning.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                        <span>Learning</span>
                    </a>
                    <a href="{{ route('tes_soal.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Tes Soal</span>
                    </a>
                    <a href="{{ route('kuis-tugas.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-tasks w-6 text-center"></i>
                        <span>Tugas</span>
                    </a>
                    @php
                        $role = auth()->user()->role;
                    @endphp
                    @if ($role === 0 || $role === 1)
                        <a href="{{ route('data-siswa') }}"
                            class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                            <i class="fas fa-users w-6 text-center"></i>
                            <span>Data Siswa</span>
                        </a>
                    @endif

                </div>

                <!-- Main Content -->
                <div class="py-12 flex-1">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <!-- Learning Title and Stage Info -->
                        <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                            <div class="text-center">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4 text-2xl font-semibold">Tahap 3 Pembimbingan Penyelidikan</p>
                            </div>
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
                                <a href="{{ route('learning.stage4', ['id' => $learning->id]) }}"
                                    class="btn btn-primary inline-block px-3 py-1 text-sm">
                                    Lanjut ke Tahap 4
                                </a>
                                <a href="{{ route('learning.activity', ['learningId' => $learning->id]) }}"
                                    class="btn btn-primary inline-block px-3 py-1 text-sm">
                                    Aktivitas Siswa
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-customold shadow-sm rounded-lg mb-6 border border-gray-300 px-6 py-5">
                            <div class="p-6 bg-white border-b border-gray-200">

                                <h2 class="text-xl font-bold mb-4">Catatan Siswa</h2>

                                <table class="min-w-full bg-white border border-gray-300 mt-6">
                                    <thead>
                                        <tr class="bg-custombone text-left">
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
                                                <td class="px-4 py-2 border">{{ $catatan->kelompok->nama_kelompok }}
                                                </td>
                                                <td class="px-4 py-2 border">{{ $catatan->isi_catatan }}</td>
                                                <td class="px-4 py-2 border">
                                                    @if ($catatan->file_catatan)
                                                        <a href="{{ asset('storage/' . $catatan->file_catatan) }}"
                                                            target="_blank" class="text-blue-500 underline">Lihat
                                                            File</a>
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
                    <!-- link sidebar -->
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fa-solid fa-house w-6 text-center"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('materiv2.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Materi</span>
                    </a>
                    <a href="{{ route('learning.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                        <span>Learning</span>
                    </a>
                    <a href="{{ route('tes_soal.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Tes Soal</span>
                    </a>
                    <a href="{{ route('kuis-tugas.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-tasks w-6 text-center"></i>
                        <span>Tugas</span>
                    </a>
                    @php
                        $role = auth()->user()->role;
                    @endphp
                    @if ($role === 0 || $role === 1)
                        <a href="{{ route('data-siswa') }}"
                            class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                            <i class="fas fa-users w-6 text-center"></i>
                            <span>Data Siswa</span>
                        </a>
                    @endif

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
                        <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                            <div class="text-center">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4 text-2xl font-semibold">Tahap 3 Pembimbingan dan Penyelidikan</p>
                                <!-- Navigation Buttons -->
                                <div class="flex justify-center mt-3 space-x-2">
                                    <a href="{{ route('learning.index') }}"
                                        class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                        Kembali ke Daftar Learning
                                    </a>
                                    <a href="{{ route('learning.stage', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                                        class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                        Kembali ke Tahap 2
                                    </a>





                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 bg-customold border-b border-gray-200">

                                <body>
                                    <h1>Compiler</h1>
                                    <iframe src="https://trinket.io/embed/python3/9c6c5027a4" width="100%"
                                        height="300" frameborder="0" marginwidth="0" marginheight="0"
                                        allowfullscreen></iframe>
                                </body>
                            </div>
                        </div>
                    </div>

                    <!-- Kontainer -->
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 bg-customold border-b border-gray-200">
                                <h1 class="text-xl font-bold mb-4">Catatan</h1>

                                <!-- Tombol Tambahkan Catatan -->
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalCatatan"
                                    class="btn btn-primary">
                                    Tambahkan Catatan
                                </button>

                                <!-- Modal Form Tambah Catatan -->
                                <div class="modal fade" id="modalCatatan" tabindex="-1"
                                    aria-labelledby="modalCatatanLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('catatan.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalPenugasanLabel">Tambah Catatan
                                                    </h5>
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
                                                        <label for="file_catatan"
                                                            class="block font-medium mb-1">Upload
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
                                                            target="_blank" class="text-blue-500 underline">Lihat
                                                            File</a>
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
                                                <div class="modal fade" id="editModal{{ $catatan->id }}"
                                                    tabindex="-1"
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
                                                                            <small class="text-gray-500">File saat ini:
                                                                                <a href="{{ asset('storage/' . $catatan->file_catatan) }}"
                                                                                    target="_blank"
                                                                                    class="text-blue-500 underline">Lihat
                                                                                    File</a></small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan
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
                                        class="btn btn-primary rounded-full">
                                        Lanjut ke Tahap 4
                                    </a>
                                @endif

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
