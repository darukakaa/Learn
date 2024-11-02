<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                @if(auth()->user()->role == '0' || auth()->user()->role == '1')
                <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Add Kuis Button -->
            <button class="bg-blue-500 text-black px-4 py-2 rounded-lg mb-4"
                onclick="document.getElementById('kuisModal').classList.remove('hidden');">
                Add Kuis
            </button>

            <!-- Kuis Modal -->
            <div id="kuisModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h2 class="text-2xl font-bold mb-4">Add Kuis</h2>
                    <form action="{{ route('kuis.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_kuis" class="block text-sm font-medium text-gray-700">Nama Kuis</label>
                            <input type="text" id="nama_kuis" name="nama_kuis"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_ditambahkan" class="block text-sm font-medium text-gray-700">Tanggal
                                Ditambahkan</label>
                            <input type="date" id="tanggal_ditambahkan" name="tanggal_ditambahkan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="bg-gray-500 text-black px-4 py-2 rounded-lg mr-2"
                                onclick="document.getElementById('kuisModal').classList.add('hidden');">Cancel</button>
                            <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded-lg">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Display Added Kuis as Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kuis as $item)
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
                    <h3 class="text-xl font-semibold mb-2">{{ $item->nama_kuis }}</h3>
                    <a href="{{ route('kuis.show', $item->id) }}" class="block w-full h-full">
                        <div
                            class="card-container bg-white rounded-lg shadow-md w-full h-full flex justify-center items-center hover:bg-gray-100 transition">
                            <h1 class="text-4xl font-bold text-gray-800">{{ $item->nama_kuis }}</h1>
                        </div>
                    </a>

                    <p class="text-gray-600 mb-4">Tanggal Ditambahkan: {{ $item->tanggal_ditambahkan }}</p>
                    <div class="mt-auto flex space-x-4">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('kuis.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
