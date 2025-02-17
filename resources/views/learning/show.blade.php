<x-app-layout>
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
        <div class="flex">
            <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
                <nav class="flex-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                    <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                    <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                    <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                        <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                    @endif
                </nav>
            </div>

            <!-- Main Content -->
            <div class="py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 1 Pengidentifikasian Masalah</p>
                        </div>
                        <a href="{{ route('learning.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar
                            Learning</a>
                    </div>


                    <!-- Check if Learning Stage 1 data exists -->
                    @php
                        $learningStage1 = App\Models\LearningStage1::where('learning_id', $learning->id)->first();
                    @endphp

                    @if ($learningStage1)
                        <!-- Display Data -->
                        <div class="bg-white shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200 flex">
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
                                    <table class="min-w-full border-collapse">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 border-b text-left">Nama</th>
                                                <th class="px-4 py-2 border-b text-left">Hasil Identifikasi Masalah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($learningStage1->learningStage1Results as $result)
                                                <tr>
                                                    <td class="px-4 py-2 border-b">{{ $result->user->name }}</td>
                                                    <td class="px-4 py-2 border-b">{{ $result->result }}</td>
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
                                    <div id="success-notification" class="bg-green-100 text-green-800 p-4 mb-4 rounded">
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

                    <!-- Navigation Buttons (Back and Next) -->
                    <div class="flex justify-between mt-6">
                        <form method="GET" action="{{ route('learning.stage2', ['learningId' => $learning->id]) }}">
                            <button type="submit"
                                class="bg-gray-500 text-white font-bold py-2 px-6 rounded-full hover:bg-gray-600">
                                Selanjutnya
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- user --}}
    @if (auth()->user()->role == '2')
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
                <nav class="flex-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                    <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                    <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                        <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                    @endif
                </nav>
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
                        @if (!$existingResult)
                            <p>Anda telah menambahkan hasil identifikasi masalah.</p>
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
                        @else
                            <p class="text-red-500">Anda telah menambahkan hasil identifikasi masalah.</p>
                        @endif
                        @if (session('error'))
                            <div id="error-notification" class="bg-red-100 text-red-800 p-4 mb-4 rounded">
                                {{ session('error') }}
                            </div>

                            <script>
                                setTimeout(function() {
                                    document.getElementById('error-notification').style.display = 'none';
                                }, 1000); // 1000ms = 1 detik
                            </script>
                        @endif

                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-6">
                        <form method="GET"
                            action="{{ route('learning.stage2', ['learningId' => $learning->id]) }}">
                            <button type="submit"
                                class="bg-gray-500 text-white font-bold py-2 px-6 rounded-full hover:bg-gray-600">
                                Selanjutnya
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif


</x-app-layout>
