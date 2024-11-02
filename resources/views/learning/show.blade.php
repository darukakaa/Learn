<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                @if(auth()->user()->role == '0' || auth()->user()->role == '1')
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
                </div>

                <!-- Form Section -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Form for Adding Problem and Uploading File -->
                        <form method="post" action="{{ route('learning.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Add Problem Input -->
                            <div class="mb-4">
                                <label for="problem" class="block text-gray-700">Tambahkan Permasalahan</label>
                                <input type="text" name="problem" id="problem" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            </div>

                            <!-- File Upload Input -->
                            <div class="mb-4">
                                <label for="file" class="block text-gray-700">Upload File (Image Only)</label>
                                <input type="file" name="file" id="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" accept="image/*">
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-center">
                                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Navigation Buttons (Back and Next) -->
                <div class="flex justify-between mt-6">
                    <!-- Back Button -->
                    <a href="#" class="px-4 py-2 bg-gray-400 text-white rounded-lg">Kembali</a>

                    <!-- Next Stage Button -->
                    <form method="get" action="{{ route('learning.show', ['learning' => $learning->id, 'stage' => 2]) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg">Selanjutnya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
