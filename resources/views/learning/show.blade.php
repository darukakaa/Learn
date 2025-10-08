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
                        <div class="text-center">
                            <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4 text-2xl font-semibold">Tahap 1 Pengidentifikasian Masalah</p>
                        </div>

                        <div class="flex justify-center mt-3 space-x-2">
                            <a href="{{ route('learning.index') }}"
                                class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                Kembali ke Daftar Learning
                            </a>

                            <button type="button" id="btnLanjut"
                                class="btn btn-primary inline-block px-3 py-1 text-sm">
                                Lanjut Tahap 2
                            </button>

                            <script>
                                document.getElementById('btnLanjut').addEventListener('click', function() {
                                    window.location.href = "{{ route('learning.stage2', ['learningId' => $learning->id]) }}";
                                });
                            </script>

                            <a href="{{ route('learning.activity', ['learningId' => $learning->id]) }}"
                                class="btn btn-primary inline-block px-3 py-1 text-sm">
                                Aktivitas Siswa
                            </a>
                        </div>
                    </div>

                    @php
                        $learningStage1 = App\Models\LearningStage1::where('learning_id', $learning->id)->first();
                    @endphp

                    @if ($learningStage1)
                        <div class="bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-customold shadow-sm sm:rounded-lg border-b border-gray-200 flex">
                                <div class="w-1/2">
                                    <h3 class="text-lg font-semibold mb-2">Permasalahan</h3>
                                    <p>{{ $learningStage1->problem ?? '-' }}</p>

                                    <h3 class="text-lg font-semibold mt-4 mb-2">File</h3>

                                    @if ($learningStage1 && $learningStage1->file)
                                        @php
                                            $ext = strtolower(pathinfo($learningStage1->file, PATHINFO_EXTENSION));
                                            $fileUrl = asset('storage/' . $learningStage1->file);
                                        @endphp

                                        {{-- Jika file berupa gambar --}}
                                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ $fileUrl }}" alt="Gambar"
                                                class="img-fluid rounded shadow" style="width: 400px; height: auto;">
                                            <div class="mt-2">
                                                <a href="{{ $fileUrl }}" download
                                                    class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                    <i class="fas fa-download"></i> Download Gambar
                                                </a>
                                            </div>

                                            {{-- Jika file berupa PDF --}}
                                        @elseif ($ext === 'pdf')
                                            <iframe src="{{ $fileUrl }}" width="100%" height="500px"
                                                class="border rounded shadow"></iframe>
                                            <div class="mt-2">
                                                <a href="{{ $fileUrl }}" download
                                                    class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                    <i class="fas fa-download"></i> Download PDF
                                                </a>
                                            </div>

                                            {{-- Jika file berupa Word --}}
                                        @elseif (in_array($ext, ['doc', 'docx']))
                                            <a href="{{ $fileUrl }}" download
                                                class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                <i class="fas fa-download"></i> Download File Word
                                            </a>

                                            {{-- Jika jenis file tidak dikenal --}}
                                        @else
                                            <p>Jenis file tidak dikenali.</p>
                                            <a href="{{ $fileUrl }}" download
                                                class="inline-block px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                                                <i class="fas fa-download"></i> Download File
                                            </a>
                                        @endif
                                    @else
                                        <p class="text-gray-500">Tidak ada file yang diunggah.</p>
                                    @endif
                                </div>

                                <div class="w-1/2 ml-6">
                                    <h3 class="text-lg font-semibold mb-4">Hasil Identifikasi Masalah</h3>

                                    <div class="mb-4 flex space-x-4 items-center">
                                        <form action="{{ route('learning.validateAllResults', $learningStage1->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary text-white px-3 py-1 rounded">
                                                Validasi Semua
                                            </button>
                                        </form>
                                    </div>

                                    <div class="max-h-[500px] overflow-y-auto border border-black rounded">
                                        <table class="min-w-full border border-black">
                                            <thead class="bg-custombone sticky top-0 z-10">
                                                <tr>
                                                    <th class="px-4 py-2 border border-black text-left text-black">Nama
                                                    </th>
                                                    <th class="px-4 py-2 border border-black text-left text-black">Hasil
                                                        Identifikasi Masalah</th>
                                                    <th class="px-4 py-2 border border-black text-left text-black">Aksi
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($learningStage1->learningStage1Results as $result)
                                                    <tr class="hover:bg-gray-100">
                                                        <td class="px-4 py-2 border border-black">
                                                            {{ $result->user->name }}</td>
                                                        <td class="px-4 py-2 border border-black">{{ $result->result }}
                                                        </td>
                                                        <td class="px-4 py-2 border border-black">
                                                            <form
                                                                action="{{ route('identifikasi.toggleValidation', $result->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="{{ $result->is_validated ? 'bg-red-500' : 'bg-blue-500' }} text-white px-3 py-1 rounded">
                                                                    {{ $result->is_validated ? 'Unvalidasi' : 'Validasi' }}
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
                    @else
                        <div class="bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <form method="POST"
                                    action="{{ route('learning.stage1.store', ['id' => $learning->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="learning_id" value="{{ $learning->id }}">

                                    <div class="mb-4">
                                        <label for="problem" class="block text-gray-700">Permasalahan</label>
                                        <input type="text" name="problem" id="problem"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                    </div>

                                    <div class="mb-4">
                                        <label for="file" class="block text-gray-700">Upload File
                                            (jpg/png/pdf/doc)</label>
                                        <input type="file" name="file" id="file"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    </div>

                                    <div class="flex justify-center">
                                        <button type="submit"
                                            class="px-4 py-2 bg-gray-800 text-white rounded-lg">Tambah</button>
                                    </div>
                                </form>

                                @if (session('success'))
                                    <div id="success-notification"
                                        class="bg-green-100 text-green-800 p-4 mb-4 rounded">
                                        {{ session('success') }}
                                    </div>

                                    <script>
                                        setTimeout(function() {
                                            document.getElementById('success-notification').style.display = 'none';
                                        }, 1000);
                                    </script>
                                @endif
                            </div>
                        </div>
                    @endif
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
                    <!-- Learning Title -->
                    <div class="bg-customold shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                        <div class="flex items-center justify-between">
                            <!-- Bagian kiri: judul -->
                            <div class="text-left">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-2 text-2xl font-semibold">Tahap 1 Pengidentifikasian Masalah</p>
                                <div class="mt-3">
                                    <a href="{{ route('learning.index') }}"
                                        class="btn btn-secondary inline-block px-3 py-1 text-sm">
                                        Kembali ke Daftar Learning
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
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                let target = {{ $progress }}; // ambil nilai progress dari controller
                                let circle = document.getElementById("progressCircle");
                                let text = document.getElementById("progressText");

                                let radius = 50;
                                let circumference = 2 * Math.PI * radius;

                                // pastikan dasharray sesuai keliling
                                circle.style.strokeDasharray = circumference;
                                circle.style.strokeDashoffset = circumference;

                                // jalankan animasi lingkaran
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


                    <!-- Flex Container for Left and Right -->
                    <div class="bg-customold shadow-sm sm:rounded-lg p-6">

                        @if ($existingResult && is_object($existingResult))
                            <p class="text-black-600 font-semibold mb-4">Anda telah menambahkan hasil identifikasi
                                masalah.</p>
                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Hasil Identifikasi Masalah
                                </h2>
                                <table class="min-w-full bg-white border border-gray-300 rounded-md">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left border-b">No</th>
                                            <th class="px-4 py-2 text-left border-b">Isi Hasil Identifikasi</th>
                                            <th class="px-4 py-2 text-left border-b">Tanggal Dibuat</th>
                                            <th class="px-4 py-2 text-left border-b">Status Validasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="px-4 py-2 border-b">1</td>
                                            <td class="px-4 py-2 border-b">{{ $existingResult->result }}</td>
                                            <td class="px-4 py-2 border-b">
                                                {{ $existingResult->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="px-4 py-2 border-b">
                                                @if ($existingResult->is_validated)
                                                    <span class="text-green-600 font-semibold">Tervalidasi</span>
                                                @else
                                                    <span class="text-red-600 font-semibold">Belum
                                                        Divalidasi</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if (is_null($existingResult) && $learningStage1)
                            <!-- Form tambah hasil identifikasi masalah -->
                            <form method="POST"
                                action="{{ route('learning.stage1.result.store', ['learningStage1Id' => $learningStage1->id]) }}">
                                @csrf
                                <input type="hidden" name="learning_stage1_id" value="{{ $learningStage1->id }}">
                                <div class="flex justify-between space-x-6">
                                    <!-- Left: Permasalahan -->
                                    <div class="w-1/2">
                                        <label for="problem"
                                            class="block text-gray-700 font-semibold mb-2">Permasalahan</label>
                                        <input class="form-control form-control-lg" type="text"
                                            value="{{ $learningStage1->problem ?? '' }}" readonly>

                                        <label for="file"
                                            class="block text-gray-700 font-semibold mb-2 mt-4">File</label>

                                        @if ($learningStage1 && $learningStage1->file)
                                            @php
                                                $ext = strtolower(pathinfo($learningStage1->file, PATHINFO_EXTENSION));
                                                $fileUrl = asset('storage/' . $learningStage1->file);
                                            @endphp

                                            {{-- Jika file berupa gambar --}}
                                            @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                <img src="{{ $fileUrl }}" style="width: 400px; height: auto;"
                                                    alt="Gambar">
                                                <div class="mt-2">
                                                    <a href="{{ $fileUrl }}" download
                                                        class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                                        <i class="fa-solid fa-download mr-2"></i> Download Gambar
                                                    </a>
                                                </div>

                                                {{-- Jika file berupa PDF --}}
                                            @elseif ($ext === 'pdf')
                                                <iframe src="{{ $fileUrl }}" width="100%"
                                                    height="500px"></iframe>
                                                <div class="mt-2">
                                                    <a href="{{ $fileUrl }}" download
                                                        class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                                        <i class="fa-solid fa-download mr-2"></i> Download PDF
                                                    </a>
                                                </div>

                                                {{-- Jika file berupa Word --}}
                                            @elseif (in_array($ext, ['doc', 'docx']))
                                                <a href="{{ $fileUrl }}" download
                                                    class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                                    <i class="fa-solid fa-file-word mr-2"></i> Download File Word
                                                </a>

                                                {{-- Jika jenis file tidak dikenali --}}
                                            @else
                                                <p>Jenis file tidak dikenali</p>
                                            @endif
                                        @else
                                            <p>Tidak ada file yang diunggah</p>
                                        @endif
                                    </div>



                                    <!-- Right: Hasil Identifikasi Masalah -->
                                    <div class="w-1/2">
                                        <label for="result" class="block text-gray-700 font-semibold mb-2">Hasil
                                            Identifikasi Masalah</label>
                                        <textarea name="result" id="result" rows="8"
                                            class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-200"></textarea>
                                    </div>
                                </div>

                                <div class="flex justify-center mt-6">
                                    <button type="submit"
                                        class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                                        Tambah
                                    </button>
                                </div>
                            </form>
                        @elseif (is_null($existingResult) && !$learningStage1)
                            <div class="text-red-600 font-semibold text-center">
                                Permasalahan belum tersedia. Silakan tunggu admin/guru menambahkannya.
                            </div>
                        @endif

                        @if (session('error'))
                            <div id="error-notification" class="bg-red-100 text-red-800 p-4 mb-4 rounded">
                                {{ session('error') }}
                            </div>

                            <script>
                                setTimeout(function() {
                                    document.getElementById('error-notification').style.display = 'none';
                                }, 1000);
                            </script>
                        @endif

                        <!-- Navigation Buttons -->
                        @if ($existingResult && is_object($existingResult) && $existingResult->is_validated)
                            <div class="flex justify-between mt-6">
                                <form method="GET"
                                    action="{{ route('learning.stage2', ['learningId' => $learning->id]) }}">
                                    <button type="submit" class="btn btn-primary rounded-full">
                                        Selanjutnya
                                    </button>
                                </form>
                            </div>
                        @endif
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
