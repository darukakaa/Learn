<x-app-layout>
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
        <div class="flex">
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
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 2 Pengorganisasian Siswa</p>
                        </div>
                        <a href="{{ route('learning.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar
                            Learning</a>
                    </div>

                    <!-- Success Message (If Available) -->
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Form Tambah Kelompok -->
                    <div class="container mb-6">
                        <h1 class="text-2xl font-bold">Tambah Kelompok</h1>
                        <form action="{{ route('kelompok.store', ['learningId' => $learning->id, 'stageId' => 2]) }}"
                            method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="nama_kelompok" class="block text-sm font-medium text-gray-700">Nama
                                    Kelompok</label>
                                <input type="text" id="nama_kelompok" name="nama_kelompok"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="jumlah_kelompok" class="block text-sm font-medium text-gray-700">Jumlah
                                    Kelompok</label>
                                <select id="jumlah_kelompok" name="jumlah_kelompok"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
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
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <h2 class="text-lg font-semibold">{{ $k->nama_kelompok }}</h2>
                                <p class="text-sm mt-2">Jumlah Kelompok: {{ $k->jumlah_kelompok }}</p>
                                <p class="text-sm mt-2">Tahap: {{ $k->stage_id }}</p>

                                <!-- Delete Button -->
                                <form action="{{ route('kelompok.destroy', $k->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    @endif
</x-app-layout>
