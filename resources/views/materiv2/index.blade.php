<x-app-layout>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <div class="flex-1">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">

                                <h1 class="text-2xl font-bold mb-4">List Materi</h1>
                                @if (session('success'))
                                    <div class="text-green-600 mb-4">{{ session('success') }}</div>
                                @endif

                                @php $role = auth()->user()->role; @endphp

                                @if ($role === 0 || $role === 1)
                                    <button onclick="document.getElementById('modal').classList.remove('hidden')"
                                        class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        + Tambah Materi
                                    </button>
                                @endif

                                <!-- Modal -->
                                <div id="modal"
                                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                                    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
                                        <h2 class="text-xl font-semibold mb-4">Tambah Materi</h2>
                                        <form action="{{ route('materiv2.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block mb-1">Nama Materi</label>
                                                <input type="text" name="nama_materi"
                                                    class="w-full border px-3 py-2 rounded" required>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block mb-1">Tanggal</label>
                                                <input type="date" name="tanggal"
                                                    class="w-full border px-3 py-2 rounded" required>
                                            </div>
                                            <div class="flex justify-end space-x-2">
                                                <button type="button"
                                                    onclick="document.getElementById('modal').classList.add('hidden')"
                                                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Tampilkan Materi -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                                    @forelse ($materi as $item)
                                        <div
                                            class="relative bg-custombone shadow p-4 rounded hover:bg-customold transition">
                                            <a href="{{ route('materiv2.show', $item->id) }}">
                                                <h3 class="text-lg font-semibold text-blue-600 hover:underline">
                                                    {{ $item->nama_materi }}
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                                </p>
                                            </a>

                                            @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                                                <form id="hapus-form-{{ $item->id }}"
                                                    action="{{ route('materiv2.destroy', $item->id) }}" method="POST"
                                                    class="absolute top-2 right-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="konfirmasiHapus({{ $item->id }})"
                                                        class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif

                                        </div>

                                    @empty

                                        <p>Tidak ada materi.</p>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function konfirmasiHapus(id) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('hapus-form-' + id).submit();
                    }
                });
            }
        </script>

        <!-- Footer: di luar container flex-row, full width -->
        <footer class="bg-customBlack text-center py-2 px-4 text-sm">
            <p class="text-customGrayLight">&copy; Learnify 2024</p>
        </footer>
    </div>
</x-app-layout>
