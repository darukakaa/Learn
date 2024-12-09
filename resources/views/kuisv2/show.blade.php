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

                <!-- Form Section (Only for Admin and Guru roles) -->
                @if (auth()->user()->role == '0' || auth()->user()->role == '1')
                    <div class="bg-white p-6 rounded shadow-lg w-1/2">
                        <h2 class="text-xl font-bold mb-4">Tambah Soal Kuis</h2>
                        <form action="{{ route('questions.store', $kuis->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="question" class="block text-gray-700">Soal</label>
                                <input type="text" id="question" name="question" required
                                    class="w-full border border-gray-300 p-2 rounded">
                            </div>

                            <!-- New Image Upload Field -->
                            <div class="mb-4">
                                <label for="image" class="block text-gray-700">Gambar Soal (Optional)</label>
                                <input type="file" id="image" name="image" accept="image/*"
                                    class="w-full border border-gray-300 p-2 rounded">
                            </div>

                            <!-- Options and Correct Answer Fields... -->
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
                @endif

                <!-- Questions List Section (for Users) -->
                <div class="bg-white p-6 rounded shadow-lg w-full max-w-4xl">
                    <a href="{{ route('kuisv2.index') }}" class="btn btn-primary mb-4">Kembali ke Daftar Kuis</a>
                    <h2 class="text-xl font-bold mb-4">Soal Kuis yang Telah Ditambahkan</h2>
                    @if ($questions->count() > 0)
                        <form action="{{ route('answers_v2.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kuis_id" value="{{ $kuis->id }}">
                            <!-- Daftar Soal -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                                @foreach ($questions as $question)
                                    <div class="border p-4 rounded shadow">
                                        <!-- Gambar dan Soal -->
                                        @if ($question->image)
                                            <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Soal"
                                                class="w-full h-auto mb-4">
                                        @endif
                                        <strong class="block mb-2">{{ $question->question }}</strong>

                                        <!-- Pilihan Jawaban -->
                                        <div class="text-sm text-gray-600 space-y-2">
                                            <label class="block">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="A" required>
                                                <strong>A:</strong> {{ $question->option_a }}
                                            </label>
                                            <label class="block">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="B">
                                                <strong>B:</strong> {{ $question->option_b }}
                                            </label>
                                            <label class="block">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="C">
                                                <strong>C:</strong> {{ $question->option_c }}
                                            </label>
                                            <label class="block">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="D">
                                                <strong>D:</strong> {{ $question->option_d }}
                                            </label>
                                            <label class="block">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="E">
                                                <strong>E:</strong> {{ $question->option_e }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if (auth()->user()->role == '2')
                                <div class="flex justify-end mt-4">
                                    <button type="submit" class="btn btn-success">Submit Jawaban</button>
                                </div>
                            @endif
                        </form>
                    @else
                        <p class="text-gray-600">Belum ada soal yang ditambahkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
