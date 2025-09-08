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
        <!-- Main Content -->
        <div class="main-content py-12 flex-1">
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($tes as $item)
                            <div
                                class="relative bg-custombone shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200 hover:bg-customold transition flex flex-col">
                                @php
                                    $jumlahSoal = \App\Models\Soal::where('tes_soals_id', $item->id)->count();
                                    $user = auth()->user();
                                    $sudahMengerjakan = \App\Models\Jawaban::where('user_id', $user->id)
                                        ->whereIn(
                                            'soal_id',
                                            \App\Models\Soal::where('tes_soals_id', $item->id)->pluck('id'),
                                        )
                                        ->exists();
                                @endphp


                                <div class="block p-6 text-center">
                                    <h3 class="text-lg font-bold mb-2">{{ $item->nama_tes }}</h3>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->tanggal_tes)->translatedFormat('d F Y') }}
                                    </p>

                                    <div class="mt-3 space-y-1">
                                        @if ($user->role === 0 || $user->role === 1)
                                            <a href="{{ route('tes_soal.show', $item->id) }}"
                                                class="inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                                Masuk Tes
                                            </a>
                                        @elseif ($user->role == 2 && $item->soal_count > 0 && !$sudahMengerjakan)
                                            <a href="{{ route('tes_soal.show', $item->id) }}"
                                                class="inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                                Masuk Tes
                                            </a>
                                        @elseif ($item->soal_count === 0)
                                            <p class="text-sm text-red-500 mt-2">Tes belum memiliki soal</p>
                                        @endif

                                        @if ($user->role == 2 && $sudahMengerjakan)
                                            <a href="{{ route('nilai_tes.index', ['userId' => $user->id, 'tesSoalId' => $item->id]) }}"
                                                class="inline-block bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                                                Nilai Anda
                                            </a>
                                        @endif
                                    </div>

                                </div>

                                @if ($user->role === 0 || $user->role === 1)
                                    <div class="bg-gray-200 text-center py-2 flex justify-around">
                                        <button
                                            onclick="editTes({{ $item->id }}, '{{ $item->nama_tes }}', '{{ $item->tanggal_tes }}')"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                            Edit
                                        </button>

                                        <button onclick="confirmDeleteTes({{ $item->id }})"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                            Hapus
                                        </button>

                                        <a href="{{ route('nilai_tes.siswa', ['tesSoalId' => $item->id]) }}"
                                            class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm">
                                            Nilai Siswa
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tambah Tes Modal -->
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

                <!-- Edit Tes Modal -->
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

        function confirmDeleteTes(tesId) {
            Swal.fire({
                title: 'Yakin ingin menghapus tes ini?',
                text: "Data tes akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/tessoal/' + tesId;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
