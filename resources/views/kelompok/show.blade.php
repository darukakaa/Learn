<x-app-layout>
    <div class="py-12">
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
                <!-- Menampilkan pesan error jika ada -->
                @if (session('error'))
                    <div class="alert alert-danger mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <h1 class="text-2xl font-bold">{{ $kelompok->nama_kelompok }}</h1>
                <p class="mt-2">Jumlah Kelompok: {{ $kelompok->jumlah_kelompok }}</p>
                <p class="mt-2">
                    Terisi: {{ $kelompok->anggota->count() }} dari {{ $kelompok->jumlah_kelompok }}
                </p>
                <p class="mt-2">Tahap: {{ $kelompok->stage_id }}</p>

                {{-- Tombol Gabung untuk User --}}
                @if (auth()->user()->role == '2' && $kelompok->anggota->count() < $kelompok->jumlah_kelompok)
                    <form action="{{ route('kelompok.storeUser', ['kelompokId' => $kelompok->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="learning_id" value="{{ $learning->id }}">
                        <input type="hidden" name="kelompok_id" value="{{ $kelompok->id }}">
                        <button type="submit" class="btn btn-primary">
                            Gabung Kelompok
                        </button>
                    </form>
                @elseif(auth()->user()->role == '2' && $kelompok->anggota->count() == $kelompok->jumlah_kelompok)
                    <p class="mt-4 text-red-500">Kelompok ini sudah penuh.</p>
                @endif

                {{-- Tombol Kelola Anggota untuk Admin / Guru --}}
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('kelompok.manage', ['learningId' => $learning->id, 'kelompokId' => $kelompok->id]) }}"
                        class="btn btn-primary">
                        Kelola Anggota
                    </a>
                @endif

                <a href="{{ route('learning.stage', ['learningId' => 24, 'stageId' => 2]) }}"
                    class="btn btn-secondary">
                    Kembali ke Daftar Kelompok
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
