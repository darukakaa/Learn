<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 text-white flex flex-col">
            <nav class="flex-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('materi.index') }}" class="block px-4 py-2 hover:bg-gray-700">Materi</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Learning</a>
                <a href="{{ route('kuis-tugas.index') }}" class="block px-4 py-2 hover:bg-gray-700">Kuis/Tugas</a>
                <a href="{{ route('modul.index') }}" class="block px-4 py-2 hover:bg-gray-700">Modul</a>
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <a href="{{ route('data-siswa') }}" class="block px-4 py-2 hover:bg-gray-700">Data Siswa</a>
                @endif
            </nav>
        </div>

        <div class="flex justify-center items-start h-screen p-4 w-full">
            <div class="flex space-x-8 w-full">

                <!-- Form Section -->
                <div class="bg-white p-6 rounded shadow-lg w-1/2">
                    <h2 class="text-xl font-bold mb-4">Tambah Soal Kuis</h2>
                    <form action="{{ route('questions.store', $kuis->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="question" class="block text-gray-700">Soal</label>
                            <input type="text" id="question" name="question" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="option_a" class="block text-gray-700">Pilihan A</label>
                            <input type="text" id="option_a" name="option_a" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="option_b" class="block text-gray-700">Pilihan B</label>
                            <input type="text" id="option_b" name="option_b" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="option_c" class="block text-gray-700">Pilihan C</label>
                            <input type="text" id="option_c" name="option_c" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="option_d" class="block text-gray-700">Pilihan D</label>
                            <input type="text" id="option_d" name="option_d" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="option_e" class="block text-gray-700">Pilihan E</label>
                            <input type="text" id="option_e" name="option_e" required
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>

                        <div class="mb-4">
                            <label for="correct_answer" class="block text-gray-700">Jawaban Benar</label>
                            <select id="correct_answer" name="correct_answer" required
                                class="w-full border border-gray-300 p-2 rounded">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="button"
                                onclick="document.getElementById('addQuestionModal').classList.add('hidden')"
                                class="btn btn-secondary">Batal</button>
                            <button type="submit" class="btn btn-success">Tambah Soal</button>
                        </div>
                    </form>
                </div>

                <!-- Questions List Section -->
                <div class="bg-white p-6 rounded shadow-lg w-1/2">
                    <h2 class="text-xl font-bold mb-4">Soal Kuis yang Telah Ditambahkan</h2>
                    @if ($questions->count() > 0)
                        <ul class="space-y-4">
                            @foreach ($questions as $question)
                                <li class="border-b pb-2">
                                    <strong>{{ $question->question }}</strong>
                                    <div class="text-sm text-gray-600">
                                        <p><strong>A:</strong> {{ $question->option_a }}</p>
                                        <p><strong>B:</strong> {{ $question->option_b }}</p>
                                        <p><strong>C:</strong> {{ $question->option_c }}</p>
                                        <p><strong>D:</strong> {{ $question->option_d }}</p>
                                        <p><strong>E:</strong> {{ $question->option_e }}</p>
                                        <p><strong>Jawaban Benar:</strong> {{ $question->correct_answer }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">Belum ada soal yang ditambahkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
