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
                    <!-- link sidebar seperti sebelumnya -->
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fa-solid fa-house w-6 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('materi.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-book w-6 text-center"></i>
                        <span>Materi</span>
                    </a>
                    <a href="{{ route('learning.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                        <span>Learning</span>
                    </a>
                    <a href="{{ route('kuis-tugas.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-tasks w-6 text-center"></i>
                        <span>Kuis/Tugas</span>
                    </a>
                    <a href="{{ route('data-siswa') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span>Data Siswa</span>
                    </a>
                    <a href="{{ route('modul.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Modul</span>
                    </a>
                </div>

                <!-- Main Content -->
                <div class="py-12 flex-1">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <!-- Learning Title and Stage Info -->
                        <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                            <div class="text-center">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4 text-2xl font-semibold">Tahap 2 Pengorganisasian Siswa</p>
                            </div>
                            <div class="flex justify-center mt-3 space-x-2">
                                <a href="{{ route('learning.index') }}"
                                    class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                    Kembali ke Daftar Learning
                                </a>
                                <a href="{{ route('learning.show', ['learning' => $learning->id]) }}"
                                    class="btn btn-primary inline-block px-3 py-1 text-sm">
                                    Kembali ke Tahap 1
                                </a>

                                <a href="{{ route('learning.stage3', ['learningId' => $learning->id]) }}"
                                    class="btn btn-primary inline-block px-3 py-1 text-sm">
                                    Lanjut Tahap 3
                                </a>
                                <a href="{{ route('learning.activity', ['learningId' => $learning->id]) }}"
                                    class="btn btn-primary inline-block px-3 py-1 text-sm">
                                    Aktivitas Siswa
                                </a>
                            </div>
                        </div>

                        <!-- ✅ Success Message (Auto Hide After 1s) -->
                        @if (session('success'))
                            <div id="success-message" class="bg-dark-500 text-white p-4 rounded-md mb-4">
                                {{ session('success') }}
                            </div>

                            <script>
                                setTimeout(() => {
                                    let message = document.getElementById('success-message');
                                    if (message) {
                                        message.style.transition = "opacity 0.5s";
                                        message.style.opacity = "0"; // Efek fade-out
                                        setTimeout(() => message.remove(), 500); // Hapus elemen setelah fade-out selesai
                                    }
                                }, 1000); // Notifikasi hilang setelah 1 detik
                            </script>
                        @endif

                        <!-- Form Tambah -->
                        <div class="bg-customold shadow-sm rounded-lg mb-6 border border-gray-300 px-6 py-5">
                            <h2 class="text-xl font-bold mb-4">Tambah Kelompok</h2>
                            <form
                                action="{{ route('kelompok.store', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                                method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="nama_kelompok" class="block text-sm font-medium text-gray-700">Nama
                                        Kelompok</label>
                                    <input type="text" id="nama_kelompok" name="nama_kelompok"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah_kelompok" class="block text-sm font-medium text-gray-700">Jumlah
                                        Kelompok</label>
                                    <select id="jumlah_kelompok" name="jumlah_kelompok"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                                        required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                        </div>


                        <!-- Kelompok Cards (Menampilkan Kelompok yang sudah ditambahkan) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($kelompok as $k)
                                <a href="{{ route('kelompok.stage2.show', ['learning' => $learning->id, 'id' => $k->id]) }}"
                                    class="block bg-customold p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                    <h2 class="text-lg font-semibold">{{ $k->nama_kelompok }}</h2>
                                    <p class="text-sm mt-2">Jumlah Kelompok: {{ $k->jumlah_kelompok }}</p>

                                    <p class="text-sm mt-2">Anggota yang Bergabung: {{ $k->anggota->count() }} /
                                        {{ $k->jumlah_kelompok }}</p>
                                    <!-- Delete Button -->
                                    <form action="{{ route('kelompok.destroy', $k->id) }}" method="POST"
                                        class="mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </a>
                            @endforeach
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
                    <!-- link sidebar seperti sebelumnya -->
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fa-solid fa-house w-6 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('materi.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-book w-6 text-center"></i>
                        <span>Materi</span>
                    </a>
                    <a href="{{ route('learning.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                        <span>Learning</span>
                    </a>
                    <a href="{{ route('kuis-tugas.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-tasks w-6 text-center"></i>
                        <span>Kuis/Tugas</span>
                    </a>
                    <a href="{{ route('modul.index') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-folder w-6 text-center"></i>
                        <span>Modul</span>
                    </a>
                </div>

                <!-- Main Content -->
                <div class="py-12 flex-1">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <!-- Learning Title and Stage Info -->
                        <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                            <div class="text-center">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4 text-2xl font-semibold">Tahap 2 Pengorganisasian Siswa</p>
                                <!-- Navigation Buttons -->
                                <div class="flex justify-center mt-3 space-x-2">
                                    <a href="{{ route('learning.index') }}"
                                        class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                        Kembali ke Daftar Learning
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Kelompok Cards (Menampilkan Kelompok yang sudah ditambahkan) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($kelompok as $k)
                                <a href="{{ route('kelompok.stage2.show', ['learning' => $learning->id, 'id' => $k->id]) }}"
                                    class="block bg-customold p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                    <h2 class="text-lg font-semibold">{{ $k->nama_kelompok }}</h2>
                                    <p class="text-sm mt-2">Jumlah Kelompok: {{ $k->jumlah_kelompok }}</p>
                                    <p class="text-sm mt-2">Anggota yang Bergabung: {{ $k->anggota->count() }} /
                                        {{ $k->jumlah_kelompok }}</p>

                                </a>
                            @endforeach
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
