<x-app-layout>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded shadow-lg max-w-lg text-center">
            <h1 class="text-2xl font-bold mb-4">Hasil Kuis</h1>
            <p class="text-lg mb-2">Jawaban Benar: {{ $correctCount }} dari {{ $totalQuestions }}</p>
            <p class="text-xl font-semibold mb-6">Skor: {{ $score }}%</p>
            <a href="{{ route('kuisv2.index') }}" class="btn btn-primary">Kembali ke Daftar Kuis</a>
        </div>
    </div>
</x-app-layout>
