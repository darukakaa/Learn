<x-app-layout>
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Kelola Kelompok: {{ $kelompok->nama_kelompok }}</h1>

                <p><strong>Jumlah Maksimal:</strong> {{ $kelompok->jumlah_kelompok }}</p>
                <p><strong>Jumlah Terisi:</strong> {{ $kelompok->anggota->count() }}</p>

                <h2 class="text-xl font-semibold mt-6 mb-2">Anggota Kelompok:</h2>
                <ul class="list-disc ml-5">
                    @forelse($kelompok->anggota as $anggota)
                        <li>{{ $anggota->user->name }}</li>
                    @empty
                        <li>Belum ada anggota.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
