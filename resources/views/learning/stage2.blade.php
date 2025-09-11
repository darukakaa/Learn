<x-app-layout>
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
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
                padding-top: 4rem;
                z-index: 10;
                min-height: 100vh;
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
        </style>

        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
                crossorigin="anonymous" referrerpolicy="no-referrer" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        </head>


        <div class="min-h-screen flex bg-customGrayLight">
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
                @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                    <a href="{{ route('data-siswa') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-users w-6 text-center"></i><span>Data Siswa</span>
                    </a>
                @endif
            </div>

            <!-- Main Content -->
            <div class="main-content py-12 flex-1">
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
                        <form action="{{ route('kelompok.store', ['learningId' => $learning->id, 'stageId' => 2]) }}"
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


                    <!-- Kelompok Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($kelompok as $k)
                            <div
                                class="bg-custombone p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 hover:bg-customold transition flex flex-col justify-between h-full">
                                <!-- Card Body -->
                                <a href="{{ route('kelompok.stage2.show', ['learning' => $learning->id, 'id' => $k->id]) }}"
                                    class="block mb-4">
                                    <h2 class="text-lg font-semibold text-customBlack">{{ $k->nama_kelompok }}</h2>
                                    <p class="text-sm mt-2 text-customBlack">
                                        Jumlah Kelompok: {{ $k->jumlah_kelompok }}
                                    </p>
                                    <p class="text-sm mt-1 text-customBlack">
                                        Anggota Bergabung: {{ $k->anggota->count() }} / {{ $k->jumlah_kelompok }}
                                    </p>
                                </a>
                                <div class="mt-4">
                                    <span class="text-sm font-semibold text-gray-800 mb-2 block">Anggota
                                        kelompok</span>
                                    <div class="flex flex-wrap items-center gap-4">
                                        @foreach ($k->anggota->take(5) as $anggota)
                                            <div class="flex items-center space-x-2">
                                                <!-- Avatar bulat -->
                                                <div
                                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-customBlue text-white text-sm font-bold">
                                                    {{ strtoupper(substr($anggota->user->name, 0, 1)) }}
                                                </div>
                                                <!-- Nama user -->
                                                <span class="text-sm text-gray-800">{{ $anggota->user->name }}</span>
                                            </div>
                                        @endforeach

                                        @if ($k->anggota->count() > 5)
                                            <div class="text-sm text-gray-500">
                                                +{{ $k->anggota->count() - 5 }} lainnya
                                            </div>
                                        @endif
                                    </div>
                                </div>





                                <!-- Tombol Hapus dengan SweetAlert -->
                                <button onclick="confirmDeleteKelompok({{ $k->id }})"
                                    class="mt-auto bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                                    Hapus
                                </button>


                                <!-- Form Hapus (disembunyikan, dikirim via JS saat konfirmasi OK) -->
                                <form id="delete-form-{{ $k->id }}"
                                    action="{{ route('kelompok.destroy', ['learningId' => $learning->id, 'id' => $k->id]) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>




                            </div>
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
                padding-top: 4rem;
                z-index: 10;
                min-height: 100vh;
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
        </style>

        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
                crossorigin="anonymous" referrerpolicy="no-referrer" />
        </head>


        <div class="min-h-screen flex bg-customGrayLight">
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
                @if (auth()->user()->role === 0 || auth()->user()->role === 1)
                    <a href="{{ route('data-siswa') }}"
                        class="sidebar-link flex items-center px-2 py-2 rounded bg-customBlue text-customGrayLight hover:bg-customBlack transition md:justify-start justify-center">
                        <i class="fas fa-users w-6 text-center"></i><span>Data Siswa</span>
                    </a>
                @endif
            </div>

            <!-- Main Content -->
            <div class="main-content py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                        <div class="flex items-center justify-between">
                            <!-- Bagian kiri: judul -->
                            <div class="text-left">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-2 text-2xl font-semibold">Tahap 2 Pengorganisasian Siswa</p>
                                <div class="mt-3">
                                    <a href="{{ route('learning.index') }}"
                                        class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                        Kembali ke Daftar Learning
                                    </a>
                                    <a href="{{ route('learning.show', ['learning' => $learning->id]) }}"
                                        class="btn btn-primary inline-block px-3 py-1 text-sm">
                                        Kembali ke Tahap 1
                                    </a>
                                </div>
                            </div>

                            <!-- Bagian kanan: progress bar lingkaran -->
                            <div class="relative w-24 h-24">
                                <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                                    <!-- Lingkaran background -->
                                    <circle class="text-gray-300" stroke-width="10" stroke="currentColor"
                                        fill="transparent" r="45" cx="50" cy="50" />
                                    <!-- Lingkaran progress -->
                                    <circle id="progressCircle" class="text-green-500" stroke-width="10"
                                        stroke-linecap="round" stroke="currentColor" fill="transparent" r="45"
                                        cx="50" cy="50"
                                        style="stroke-dasharray: 283; stroke-dashoffset: 283; transition: stroke-dashoffset 1s ease-out;" />
                                </svg>
                                <!-- Angka % -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="progressText" class="text-lg font-bold">0%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Script animasi progress -->
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                let target = {{ $progress }}; // ambil nilai progress dari controller
                                let circle = document.getElementById("progressCircle");
                                let text = document.getElementById("progressText");

                                let radius = 45; // sesuai r circle
                                let circumference = 2 * Math.PI * radius;

                                circle.style.strokeDasharray = circumference;
                                circle.style.strokeDashoffset = circumference;

                                // animasi lingkaran
                                let offset = circumference - (target / 100) * circumference;
                                setTimeout(() => {
                                    circle.style.strokeDashoffset = offset;
                                }, 200);

                                // animasi angka
                                let current = 0;
                                let step = Math.ceil(target / 50);
                                let interval = setInterval(() => {
                                    current += step;
                                    if (current >= target) {
                                        current = target;
                                        clearInterval(interval);
                                    }
                                    text.textContent = current + "%";
                                }, 20);
                            });
                        </script>
                    </div>


                    <!-- Kelompok Cards (Menampilkan Kelompok yang sudah ditambahkan) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($kelompok as $k)
                            <a href="{{ route('kelompok.stage2.show', ['learning' => $learning->id, 'id' => $k->id]) }}"
                                class="bg-custombone p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 hover:bg-customold transition flex flex-col justify-between h-full">
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
    <script>
        function confirmDeleteKelompok(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus kelompok?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDeleteKelompok(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data kelompok akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
