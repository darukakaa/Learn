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
                        <div class="bg-white shadow-sm rounded-lg mb-4 border border-gray-300 px-4 py-3 -mt-10">
                            <div class="text-center">
                                <h1 class="text-4xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4 text-2xl font-semibold">Tahap 1 Pengidentifikasian Masalah</p>
                            </div>

                            <!-- Navigation Buttons -->
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


                        <!-- Check if Learning Stage 1 data exists -->
                        @php
                            $learningStage1 = App\Models\LearningStage1::where('learning_id', $learning->id)->first();
                        @endphp

                        @if ($learningStage1)
                            <!-- Display Data -->
                            <div class="bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white shadow-sm sm:rounded-lg border-b border-gray-200 flex">
                                    <!-- Gambar -->
                                    <div class="w-1/2">
                                        <h3 class="text-lg font-semibold">Permasalahan</h3>
                                        <p>{{ $learningStage1->problem }}</p>

                                        <h3 class="text-lg font-semibold mt-4">Gambar</h3>
                                        <img src="{{ asset('storage/' . $learningStage1->file) }}" class="img-fluid"
                                            alt="Gambar" style="width: 400px; height: auto;">
                                    </div>

                                    <!-- Tabel untuk Menampilkan Data Nama dan Hasil Identifikasi Masalah -->
                                    <div class="w-1/2 ml-6">
                                        <h3 class="text-lg font-semibold mb-4">Hasil Identifikasi Masalah</h3>
                                        <div class="mb-4 flex space-x-4 items-center">
                                            <form
                                                action="{{ route('learning.validateAllResults', $learningStage1->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-primary text-white px-3 py-1 rounded">
                                                    Validasi Semua
                                                </button>
                                            </form>


                                        </div>
                                        <table class="min-w-full border-collapse">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-2 border-b text-left">Nama</th>
                                                    <th class="px-4 py-2 border-b text-left">Hasil Identifikasi Masalah
                                                    </th>
                                                    <th class="px-4 py-2 border-b text-left">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($learningStage1->learningStage1Results as $result)
                                                    <tr>
                                                        <td class="px-4 py-2 border-b">{{ $result->user->name }}</td>
                                                        <td class="px-4 py-2 border-b">{{ $result->result }}</td>
                                                        <td class="px-4 py-2 border-b">
                                                            <form
                                                                action="{{ route('identifikasi.toggleValidation', $result->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit"
                                                                    class="{{ $result->is_validated ? 'btn btn-danger' : 'btn btn-primary' }} text-white px-3 py-1 rounded">
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
                        @else
                            <!-- Form Section -->
                            <div class="bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <!-- Form for Adding Problem and Uploading File -->
                                    <form method="POST"
                                        action="{{ route('learning.stage1.store', ['id' => $learning->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="learning_id" value="{{ $learning->id }}">

                                        <!-- Input for Problem -->
                                        <div class="mb-4">
                                            <label for="problem" class="block text-gray-700">Permasalahan</label>
                                            <input type="text" name="problem" id="problem"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                        </div>

                                        <!-- File Upload Input -->
                                        <div class="mb-4">
                                            <label for="file" class="block text-gray-700">Upload File (Image
                                                Only)</label>
                                            <input type="file" name="file" id="file"
                                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"
                                                accept="image/*">
                                        </div>

                                        <!-- Submit Button -->
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
                                            }, 1000); // 1000ms = 1 detik
                                        </script>
                                    @endif
                                </div>
                            </div>
                        @endif


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
                        <!-- Learning Title -->
                        <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                                <p class="mt-4">Tahap 1 Pengidentifikasian Masalah</p>
                            </div>
                        </div>

                        <!-- Flex Container for Left and Right -->
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <a href="{{ route('learning.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar
                                Learning</a>

                            @if ($existingResult && is_object($existingResult))
                                <p class="text-green-600 font-semibold mb-4">Anda telah menambahkan hasil identifikasi
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



                            @if (is_null($existingResult))
                                <!-- Form tambah hasil identifikasi masalah -->
                                <form method="POST"
                                    action="{{ route('learning.stage1.result.store', ['learningStage1Id' => $learningStage1->id]) }}">
                                    @csrf
                                    <input type="hidden" name="learning_stage1_id"
                                        value="{{ $learningStage1->id }}">
                                    <div class="flex justify-between space-x-6">
                                        <!-- Left: Permasalahan -->
                                        <div class="w-1/2">
                                            <label for="problem"
                                                class="block text-gray-700 font-semibold mb-2">Permasalahan</label>
                                            <input class="form-control form-control-lg" type="text"
                                                value="{{ $learningStage1->problem ?? '' }}" readonly>

                                            <label for="gambar"
                                                class="block text-gray-700 font-semibold mb-2">Gambar</label>
                                            @if ($learningStage1 && $learningStage1->file)
                                                <img src="{{ asset('storage/' . $learningStage1->file) }}"
                                                    style="width: 400px; height: auto;" alt="Gambar">
                                            @else
                                                <p>No image available</p>
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
                        </div>

                        <!-- Navigation Buttons -->
                        @if ($existingResult && is_object($existingResult) && $existingResult->is_validated)
                            <div class="flex justify-between mt-6">
                                <form method="GET"
                                    action="{{ route('learning.stage2', ['learningId' => $learning->id]) }}">
                                    <button type="submit"
                                        class="bg-gray-500 text-white font-bold py-2 px-6 rounded-full hover:bg-gray-600">
                                        Selanjutnya
                                    </button>
                                </form>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
    @endif

    <!-- Footer: di luar container flex-row, full width -->
    <footer class="bg-customBlack text-center py-2 px-4 text-sm">
        <p class="text-customGrayLight">&copy; Learnify 2024</p>
    </footer>
</x-app-layout>
