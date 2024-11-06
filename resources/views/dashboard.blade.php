<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="dashboard" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="flex justify-between items-center p-4 bg-gray-100 border-b border-gray-200">
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Siswa Dashboard') }}
                    </h2>
                </x-slot>
            </div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Cards Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Card 1 -->
                        <a href="{{ route('materi.index') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Jumlah Materi</h3>
                            <p>{{ $jumlahMateri }}</p>
                        </a>

                        <!-- Card 2 -->
                        <a href="{{ route('learning.index') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Learning</h3>
                            <p>{{ $jumlahLearning }}</p>
                        </a>

                        <!-- Card 3 -->
                        <a href="{{ route('modul.index') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Modul</h3>
                            <p>{{ $jumlahModul }}</p>
                        </a>

                        <!-- Card 4 -->
                        <a href="{{ route('tugas.index') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Tugas</h3>
                            <p>{{ $jumlahTugas }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
