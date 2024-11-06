<x-app-layout>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 h-full bg-gray-200">
            <nav class="flex flex-col p-4 space-y-4">
                <a href="{{ route('dashboard') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Dashboard</a>
                <a href="{{ route('materi.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Materi</a>
                <a href="{{ route('learning.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Kuis/Tugas</a>
                <a href="{{ route('data-siswa') }}" class="block text-center py-3 rounded bg-gray-300 text-black">Data
                    Siswa</a>
                <a href="{{ route('modul.index') }}"
                    class="block text-center py-3 rounded bg-gray-300 text-black">Modul</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="p-4 bg-gray-100 border-b border-gray-200">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
            </div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Cards Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Card 1 -->
                        <a href="{{ route('data-siswa') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Jumlah Siswa</h3>
                            <p>{{ $jumlahSiswa }}</p>
                        </a>

                        <!-- Card 2 -->
                        <a href="{{ route('learning.index') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Learning</h3>
                            <p>{{ $jumlahLearning }}</p>
                        </a>
                        <!-- Card 3 -->
                        <a href="{{ route('materi.index') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Jumlah Materi</h3>
                            <p>{{ $jumlahMateri }}</p>
                        </a>

                        <!-- Card 4 -->
                        <a href="{{ route('modul.index') }}"
                            class="bg-white shadow rounded-lg p-4 hover:bg-gray-100 transition">
                            <h3 class="font-semibold text-lg">Modul</h3>
                            <p>{{ $jumlahModul }}</p>
                        </a>

                        <!-- Card 5 -->
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
