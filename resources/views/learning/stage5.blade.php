<x-app-layout>
    @if (auth()->user()->role == '0' || auth()->user()->role == '1')
        <div class="flex">
            <!-- Sidebar -->
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
                            <p class="mt-4">Tahap 5 Pengevaluasian masalah dan Penyimpulan</p>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                        </div>
                    </div>
                </div>

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
                    <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                    <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="py-12 flex-1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Learning Title and Stage Info -->
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h1 class="text-2xl font-bold">{{ $learning->name }}</h1>
                            <p class="mt-4">Tahap 5 Pengevaluasian masalah dan Penyimpulan</p>
                        </div>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                        </div>
                    </div>
                </div>
    @endif
</x-app-layout>
