<x-app-layout>
    <div class="py-12">
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
