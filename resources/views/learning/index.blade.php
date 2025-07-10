<!-- resources/views/learning/index.blade.php -->
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
            <div class="flex-1">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <!-- Button to add new Learning -->
                        <div class="flex justify mb-4">
                            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                <button class="btn btn-primary" onclick="openAddModal()">
                                    Tambah Learning
                                </button>
                            @endif
                        </div>

                        <!-- Grid of Learning items as Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($learnings as $learning)
                                <a href="{{ route('learning.show', ['learning' => $learning->id]) }}" class="card-link">
                                    <div
                                        class="block bg-custombone shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                                        <div class="p-6 text-center">
                                            <h3 class="text-lg font-bold mb-2">{{ $learning->name }}</h3>
                                            @if ($learning->is_completed)
                                                <span
                                                    class="inline-block mt-2 px-3 py-1 bg-green-200 text-green-800 text-sm font-semibold rounded-full">
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                        <div class="bg-gray-200 text-center py-2 flex justify-around">
                                            <!-- Delete Button -->
                                            @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="event.preventDefault(); openDeleteModal({{ $learning->id }})">Hapus</button>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Learning Modal -->
        <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
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

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl mb-4">Hapus Learning</h2>
                <p>Apakah Anda yakin ingin menghapus learning ini?</p>
                <form method="POST" action="" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-4">
                        <button type="button"
                            class="bg-gray-400 hover:bg-gray-500 text-black font-bold py-2 px-4 rounded mr-2"
                            onclick="closeDeleteModal()">Batal</button>
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-black font-bold py-2 px-4 rounded">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- JavaScript for modals -->
        <script>
            function openAddModal() {
                document.getElementById('addModal').classList.remove('hidden');
            }

            function closeAddModal() {
                document.getElementById('addModal').classList.add('hidden');
            }

            function openDeleteModal(learningId) {
                document.getElementById('deleteForm').action = `/learning/${learningId}`;
                document.getElementById('deleteModal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }
        </script>
        <!-- Footer: di luar container flex-row, full width -->
        <footer class="bg-customBlack text-center py-2 px-4 text-sm">
            <p class="text-customGrayLight">&copy; Learnify 2024</p>
        </footer>
</x-app-layout>
