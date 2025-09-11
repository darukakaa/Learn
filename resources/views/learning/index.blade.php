<x-app-layout>
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

        #addModal {
            z-index: 9999;
        }
    </style>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <!-- Sidebar dan Konten -->
    <div class="min-h-screen flex bg-white relative">
        <!-- Sidebar -->
        <div class="sidebar bg-customGrayLight p-2 flex flex-col space-y-2 mt-20">
            <a href="{{ route('dashboard') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fa-solid fa-house w-6 text-center"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('materiv2.index') }}"
                class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                <i class="fa-solid fa-book-open w-6 text-center"></i><span>Materi</span>
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
            @php $role = auth()->user()->role; @endphp
            @if ($role === 0 || $role === 1)
                <a href="{{ route('data-siswa') }}"
                    class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                    <i class="fas fa-users w-6 text-center"></i><span>Data Siswa</span>
                </a>
            @endif
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col bg-customGrayLight">
            <div class="py-4 flex-grow">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if ($role === 0 || $role === 1)
                        <div class="mb-4">
                            <button class="btn btn-primary" onclick="openAddModal()">Tambah Learning</button>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($learnings as $learning)
                            <div
                                class="relative bg-custombone shadow-md rounded-lg overflow-hidden hover:shadow-xl transition hover:bg-customold flex flex-col">
                                <a href="{{ route('learning.show', ['learning' => $learning->id]) }}"
                                    class="card-link flex-1">
                                    <div class="p-6 text-center">
                                        <h3 class="text-lg font-bold mb-2">{{ $learning->name }}</h3>

                                        {{-- Progress bar hanya untuk user biasa (role = 2) --}}
                                        @if ($role === 2)
                                            <div class="relative w-20 h-20 mx-auto">
                                                <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 100 100">
                                                    <circle class="text-gray-300" stroke-width="10"
                                                        stroke="currentColor" fill="transparent" r="45" cx="50"
                                                        cy="50" />
                                                    <circle class="text-green-500" stroke-width="10"
                                                        stroke-linecap="round" stroke="currentColor" fill="transparent"
                                                        r="45" cx="50" cy="50"
                                                        style="stroke-dasharray: 283; stroke-dashoffset: {{ 283 - ($learning->progress / 100) * 283 }};" />
                                                </svg>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <span class="text-sm font-bold">{{ $learning->progress }}%</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($learning->is_completed)
                                            <span
                                                class="inline-block mt-2 px-3 py-1 bg-customlight text-green-800 text-sm font-semibold rounded-full">Selesai</span>
                                        @endif
                                    </div>
                                </a>

                                @if ($role === 0 || $role === 1)
                                    <div class="bg-customblue text-center py-2 flex justify-around">
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete({{ $learning->id }})">Hapus</button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Learning -->
    <div id="addModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl mb-4">Tambah Learning</h2>
            <form method="POST" action="{{ route('learning.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama Learning</label>
                    <input type="text" id="nama" name="nama"
                        class="w-full px-3 py-2 border border-gray-300 rounded" required>
                </div>
                <div class="flex justify-end">
                    <button type="button"
                        class="bg-gray-400 hover:bg-gray-500 text-black font-bold py-2 px-4 rounded mr-2"
                        onclick="closeAddModal()">Batal</button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-black font-bold py-2 px-4 rounded">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS & SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function confirmDelete(learningId) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data learning ini akan dihapus secara permanen.",
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
                    form.action = `/learning/${learningId}`;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <!-- Footer -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
