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
                                            <input type="date" name="tanggal" class="w-full border px-3 py-2 rounded"
                                                required>
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                                @forelse ($materi as $item)
                                    <div
                                        class="relative bg-custombone shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200 hover:bg-customold transition flex flex-col">
                                        <a href="{{ route('materiv2.show', $item->id) }}" class="block p-6 text-center">
                                            <h3 class="text-lg font-bold mb-2 text-dark hover:underline">
                                                {{ $item->nama_materi }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                            </p>
                                        </a>

                                        @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                                            <div class="bg-custombone text-center py-2 flex justify-around ">
                                                <form id="hapus-form-{{ $item->id }}"
                                                    action="{{ route('materiv2.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="konfirmasiHapus({{ $item->id }})"
                                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="col-span-3 text-center text-gray-500">Tidak ada materi.</p>
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
