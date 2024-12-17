<x-app-layout>
    <div class="container mx-auto mt-8">
        <a href="{{ route('kuisv2.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar Kuis</a>
        <h1 class="text-2xl font-bold">Hasil Nilai Kuis</h1>
        <div class="mt-4 p-4 bg-white shadow rounded">
            <p class="text-lg">Score Anda: <span class="font-bold">{{ $score }}</span></p>
        </div>

    </div>
</x-app-layout>
