<x-app-layout>
    <h1>Skor untuk Kuis: {{ $quiz->nama_kuis }}</h1>

    <p>Total Skor: {{ $score }}</p>
    <p>Jumlah Jawaban Benar: {{ $correctCount }}</p>
    <p>Total Pertanyaan: {{ $totalQuestions }}</p>
</x-app-layout>
