<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 text-gray-900 flex justify-center items-center space-x-6">
            <!-- Kuis Card -->
            <a href="{{ route('kuis.index') }}" class="block w-full h-full">
                <div
                    class="card-container bg-white rounded-lg shadow-md w-full h-full flex justify-center items-center hover:bg-gray-100 transition">
                    <h1 class="text-4xl font-bold text-gray-800">Kuis</h1>
                </div>
            </a>

            <!-- Tugas Card -->
            <a href="{{ route('tugas.index') }}" class="block w-full h-full">
                <div
                    class="card-container bg-white rounded-lg shadow-md w-full h-full flex justify-center items-center hover:bg-gray-100 transition">
                    <h1 class="text-4xl font-bold text-gray-800">Tugas</h1>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
