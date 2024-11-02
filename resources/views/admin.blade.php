<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="dashboard" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="{{ route('learning.index') }}" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <div class="flex justify-between items-center p-4 bg-gray-100 border-b border-gray-200">
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Admin Dashboard') }}
                    </h2>
                </x-slot>
            </div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                    <!-- Cards Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        <!-- Card 1 -->
                        <div class="bg-white shadow rounded-lg p-4">
                            <h3 class="font-semibold text-lg">Jumlah Siswa</h3>
                            <p>{{ $jumlahSiswa }}</p>
                            
                        </div>
                        <!-- Card 2 -->
                        <div class="bg-white shadow rounded-lg p-4">
                            <h3 class="font-semibold text-lg">Modul</h3>
                            <p>{{ $jumlahModul }}</p>
                        </div>
                        <!-- Card 3 -->
                        <div class="bg-white shadow rounded-lg p-4">
                            <h3 class="font-semibold text-lg">Card Title 3</h3>
                            <p class="mt-2 text-gray-600">Some description for card 3.</p>
                        </div>
                        <!-- Card 4 -->
                        <div class="bg-white shadow rounded-lg p-4">
                            <h3 class="font-semibold text-lg">Card Title 4</h3>
                            <p class="mt-2 text-gray-600">Some description for card 4.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
