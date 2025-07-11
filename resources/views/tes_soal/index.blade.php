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
            <div class="flex-1 p-6 text-gray-900">
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <button onclick="document.getElementById('tessoalModal').classList.remove('hidden')"
                        class="btn btn-primary mb-4">
                        Tambah Tes
                    </button>
                @endif

                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-4">Daftar Tes</h1>

                    @if (session('success'))
                        <div class="text-green-600 mb-2">{{ session('success') }}</div>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <ul class="space-y-2">
                            @foreach ($tes as $item)
                                <li class="p-4 bg-white rounded shadow">
                                    <strong>{{ $item->nama_tes }}</strong><br>
                                    <span class="text-sm text-gray-600">{{ $item->tanggal_tes }}</span>
                                    <!-- Tombol Masuk Tes -->
                                    @php
                                        $user = auth()->user();
                                        $sudahMengerjakan = \App\Models\Jawaban::where('user_id', $user->id)
                                            ->whereIn(
                                                'soal_id',
                                                \App\Models\Soal::where('tes_soals_id', $item->id)->pluck('id'),
                                            )
                                            ->exists();
                                    @endphp

                                    @if ($user->role === 0 || $user->role === 1 || ($user->role === 2 && !$sudahMengerjakan))
                                        <a href="{{ route('tes_soal.show', $item->id) }}" class="btn btn-primary">
                                            Masuk Tes
                                        </a>
                                    @endif
                                    @if ($user->role == 2)
                                        @if ($sudahMengerjakan)
                                            <a href="{{ route('nilai_tes.index', ['userId' => auth()->id(), 'tesSoalId' => $item->id]) }}"
                                                class="btn btn-primary">
                                                Nilai Anda
                                            </a>
                                        @else
                                            <p>Anda belum mengerjakan</p>
                                        @endif
                                    @endif
                                    @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                                        <div class="mt-2 flex gap-2">
                                            <!-- Tombol Edit -->
                                            <button
                                                onclick="editTes({{ $item->id }}, '{{ $item->nama_tes }}', '{{ $item->tanggal_tes }}')"
                                                class="btn btn-warning">
                                                <span>Edit</span>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('tessoal.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus tes ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                            <!-- Tombol Nilai Siswa -->
                                            <a href="{{ route('nilai_tes.siswa', ['tesSoalId' => $item->id]) }}"
                                                class="btn btn-info">
                                                Nilai Siswa
                                            </a>
                                        </div>
                                    @endif

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Add Tes Modal -->
                <div id="tessoalModal"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                    <div class="bg-white p-6 rounded shadow-lg w-1/3">
                        <h2 class="text-xl font-bold mb-4">Tambah Tes</h2>
                        <form action="{{ route('tessoal.store') }}" method="POST">

                            @csrf
                            <div class="mb-4">
                                <label for="nama_tes" class="block text-gray-700">Nama Tes</label>
                                <input type="text" name="nama_tes" required
                                    class="w-full border border-gray-300 p-2 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="tanggal_tes" class="block text-gray-700">Tanggal Tes Dibuat</label>
                                <input type="date" name="tanggal_tes" required
                                    class="w-full border border-gray-300 p-2 rounded">
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    onclick="document.getElementById('tessoalModal').classList.add('hidden')"
                                    class="btn btn-secondary">Batal</button>
                                <button type="submit" class="btn btn-success">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Kuis Modal -->
                <div id="edittesModal"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                    <div class="bg-white p-6 rounded shadow-lg w-1/3">
                        <h2 class="text-xl font-bold mb-4">Edit Tes</h2>
                        <form id="edittesForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="edit_nama_tes" class="block text-gray-700">Nama Tes</label>
                                <input type="text" id="edit_nama_tes" name="nama_tes" required
                                    class="w-full border border-gray-300 p-2 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="edit_tanggal_tes" class="block text-gray-700">Tanggal Tes Dibuat</label>
                                <input type="date" id="edit_tanggal_tes" name="tanggal_tes" required
                                    class="w-full border border-gray-300 p-2 rounded">
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    onclick="document.getElementById('edittesModal').classList.add('hidden')"
                                    class="btn btn-secondary">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        function editTes(id, nama, tanggal) {
            document.getElementById('edittesForm').action = '/tessoal/' + id;
            document.getElementById('edit_nama_tes').value = nama;
            document.getElementById('edit_tanggal_tes').value = tanggal;
            document.getElementById('edittesModal').classList.remove('hidden');
        }
    </script>

    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
